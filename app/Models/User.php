<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use App\Support\Helper;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    const DEFAULT_ORDER_BY = 'name';
    const DEFAULT_ORDER_TYPE = 'asc';
    const DEFAULT_PAGINATION_LIMIT = 40;

    const PHOTO_PATH = 'img/users';
    const PHOTO_WIDTH = 400;
    const PHOTO_HEIGHT = 400;

    protected $with = [
        'roles'
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'settings',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
        'settings' => 'array'
    ];

    // ********** Relations **********
    public function roles()
    {
        return $this->belongsToMany(Role::class);
    }

    // ********** Scopes **********
    public function scopeBdms()
    {
        return $this->whereRelation('roles', 'name', Role::BDM_NAME);
    }

    public function scopeAnalysts()
    {
        return $this->whereRelation('roles', 'name', Role::ANALYST_NAME);
    }

    // ********** Roles Check **********
    public function isAdmin()
    {
        return $this->roles->contains('name', Role::ADMIN_NAME);
    }

    public function isModerator()
    {
        return $this->roles->contains('name', Role::MODERATOR_NAME);
    }

    public function isAdminOrModerator()
    {
        return $this->roles->contains(function ($role) {
            return $role->name == Role::ADMIN_NAME
                || $role->name == Role::MODERATOR_NAME;
        });
    }

    /**
     * Robots can`t login
     */
    public function isRobot()
    {
        return $this->roles->contains('name', Role::ROBOT_NAME);
    }

    // ********** Querying **********
    public static function getItemsFinalized($params, $items = null, $finaly = 'paginate')
    {
        $items = $items ?: self::query();
        $items = self::filter($items);
        $items = self::finalize($params, $items, $finaly);

        return $items;
    }

    private static function filter($items)
    {
        return $items;
    }

    private static function finalize($params, $items, $finaly)
    {
        $items = $items
            ->orderBy($params['orderBy'], $params['orderType'])
            ->orderBy('id', $params['orderType']);

        switch ($finaly) {
            case 'paginate':
                $items = $items
                    ->paginate($params['paginationLimit'], ['*'], 'page', $params['currentPage'])
                    ->appends(request()->except('page'));
                break;

            case 'get':
                $items = $items->get();
                break;
        }

        return $items;
    }

    public static function getBdmsMinifed()
    {
        return self::bdms()->select('id', 'name')->withOnly([])->get();
    }

    public static function getAnalystsMinified()
    {
        return self::analysts()->select('id', 'name')->withOnly([])->get();
    }

    // ********** Miscellaneous **********
    /**
     * Used on creating & updating users
     * Empty settings is used for Robots
     */
    public function loadDefaultSettings()
    {
        // Refresh because roles have been updated
        $this->refresh();

        if ($this->isRobot()) {
            $this->update(['settings' => null]);
            return;
        }

        $settings = [
            'fullWidth' => 1,
            'locale' => 'ru',
        ];

        $settings['manufacturerColumns'] = $this->getDefaultManufacturerColumns();
        $settings['meetingColumns'] = $this->getDefaultMeetingColumns();
        $settings['genericColumns'] = $this->getDefaultGenericColumns();
        $settings['processColumns'] = $this->getDefaultProcessColumns();
        $settings['kvppColumns'] = $this->getDefaultKvppColumns();

        $this->update(['settings' => $settings]);
    }

    /**
     * Used in Tabled index pages, to get only users visible columns
     *
     * @param Illuminate\Support\Collection $columns;
     */
    public static function filterVisibleColumns($columns)
    {
        return $columns->where('visible', 1)->sortBy('order')->values()->all();
    }

    public static function createFromRequest($request)
    {
        $item = self::create($request->all());
        $item->uploadPhoto($request);

        // BelongsToMany relations
        $item->roles()->attach($request->input('roles'));

        $item->loadDefaultSettings();
    }

    /**
     * Used by both profile edit
     * and Admin panels user edit pages
     *
     * Old Password verification is skipped for Admin
     *
     * User settings will be reset and all sessions closed,
     * if users roles have been changed by Admin
     */
    public function updateFromRequest($request, $byAdmin)
    {
        $this->update($request->only(['name', 'email']));
        $this->updatePassword($request, $byAdmin);
        $this->uploadPhoto($request);
        $this->updateRoles($request, $byAdmin);
    }

    /**
     * Return error if users is being used
     */
    public function deleteByAdmin()
    {
        $usedAsBdm = Manufacturer::where('bdm_user_id', $this->id)->count();
        $usedAsAnalyst = Manufacturer::where('analyst_user_id', $this->id)->count();

        if ($usedAsBdm || $usedAsAnalyst) {
            throw ValidationException::withMessages([
                'user-deletion' => trans('app.user-deletion-error', ['name' => $this->name]),
            ]);
        }

        $this->delete();
    }

    private function updateRoles($request, $byAdmin)
    {
        if (!$byAdmin) return;

        $oldRoles = $this->roles()->orderBy('id')->pluck('id')->toArray();
        $newRoles = $request->input('roles');

        $this->roles()->sync($newRoles);

        // Reset user settings, if roles have been changed
        if (count(array_diff($oldRoles, $newRoles)) || count(array_diff($newRoles, $oldRoles))) {
            $this->loadDefaultSettings();
            $this->logoutAllDevicesByAdmin($request);
        }
    }

    /**
     * Update password and logout other devices
     */
    private function updatePassword($request, $byAdmin)
    {
        // current_password is used only in profile edit page
        if (!$byAdmin && !$request->current_password) return;
        if (!$request->new_password) return;

        $this->update([
            'password' => bcrypt($request->new_password)
        ]);

        // Logout other devices
        $byAdmin ? $this->logoutAllDevicesByAdmin($request) // Admin panels user edit page
            : Auth::logoutOtherDevices($request->new_password); // profile edit page
    }

    /**
     * Used by Admin on users edit page, on password or roles update
     */
    private function logoutAllDevicesByAdmin($request)
    {
        $currentAdminID = $request->user()->id;

        Auth::guard('web')->logout();
        $request->session()->invalidate();

        Auth::loginUsingId($this->id);
        Auth::logoutOtherDevices($request->new_password);

        Auth::loginUsingId($currentAdminID);
        $request->session()->regenerate();
    }

    private function uploadPhoto($request)
    {
        if (!$request->hasFile('photo')) return;

        Helper::uploadModelFile($this, 'photo', Helper::generateSlug($this->name), public_path(self::PHOTO_PATH));
        Helper::resizeImage($this->getPhotoPath(), self::PHOTO_WIDTH, self::PHOTO_HEIGHT);
    }

    private function getPhotoPath()
    {
        return public_path(self::PHOTO_PATH . '/' . $this->photo);
    }

    private function getDefaultManufacturerColumns()
    {
        $order = 1;

        return [
            ['name' => 'Edit', 'order' => $order++, 'width' => 44, 'visible' => 1],
            ['name' => 'BDM', 'order' => $order++, 'width' => 142, 'visible' => 1],
            ['name' => 'Analyst', 'order' => $order++, 'width' => 142, 'visible' => 1],
            ['name' => 'Country', 'order' => $order++, 'width' => 144, 'visible' => 1],
            ['name' => 'Manufacturer', 'order' => $order++, 'width' => 140, 'visible' => 1],
            ['name' => 'Category', 'order' => $order++, 'width' => 104, 'visible' => 1],
            ['name' => 'Status', 'order' => $order++, 'width' => 106, 'visible' => 1],
            ['name' => 'Important', 'order' => $order++, 'width' => 100, 'visible' => 1],
            ['name' => 'Product category', 'order' => $order++, 'width' => 156, 'visible' => 1],
            ['name' => 'Zones', 'order' => $order++, 'width' => 60, 'visible' => 1],
            ['name' => 'Black list', 'order' => $order++, 'width' => 140, 'visible' => 1],
            ['name' => 'Presence', 'order' => $order++, 'width' => 180, 'visible' => 1],
            ['name' => 'Website', 'order' => $order++, 'width' => 180, 'visible' => 1],
            ['name' => 'About company', 'order' => $order++, 'width' => 240, 'visible' => 1],
            ['name' => 'Relationship', 'order' => $order++, 'width' => 240, 'visible' => 1],
            ['name' => 'Comments', 'order' => $order++, 'width' => 146, 'visible' => 1],
            ['name' => 'Last comment', 'order' => $order++, 'width' => 240, 'visible' => 1],
            ['name' => 'Comments Date', 'order' => $order++, 'width' => 128, 'visible' => 1],
            ['name' => 'Date of creation', 'order' => $order++, 'width' => 138, 'visible' => 1],
            ['name' => 'Update Date', 'order' => $order++, 'width' => 150, 'visible' => 1],
            ['name' => 'Meetings', 'order' => $order++, 'width' => 106, 'visible' => 1],
            ['name' => 'ID', 'order' => $order++, 'width' => 72, 'visible' => 1],
        ];
    }

    private function getDefaultMeetingColumns()
    {
        $order = 1;

        return [
            ['name' => 'Edit', 'order' => $order++, 'width' => 44, 'visible' => 1],
            ['name' => 'Year', 'order' => $order++, 'width' => 64, 'visible' => 1],
            ['name' => 'Country', 'order' => $order++, 'width' => 144, 'visible' => 1],
            ['name' => 'Manufacturer', 'order' => $order++, 'width' => 140, 'visible' => 1],
            ['name' => 'BDM', 'order' => $order++, 'width' => 142, 'visible' => 1],
            ['name' => 'Who met', 'order' => $order++, 'width' => 142, 'visible' => 1],
            ['name' => 'Analyst', 'order' => $order++, 'width' => 142, 'visible' => 1],
            ['name' => 'Plan', 'order' => $order++, 'width' => 320, 'visible' => 1],
            ['name' => 'Topic', 'order' => $order++, 'width' => 320, 'visible' => 1],
            ['name' => 'Result', 'order' => $order++, 'width' => 320, 'visible' => 1],
            ['name' => 'Outside the exhibition', 'order' => $order++, 'width' => 320, 'visible' => 1],
            ['name' => 'ID', 'order' => $order++, 'width' => 90, 'visible' => 1],
        ];
    }

    private function getDefaultGenericColumns()
    {
        $order = 1;

        return [
            ['name' => 'Edit', 'order' => $order++, 'width' => 44, 'visible' => 1],
            ['name' => 'Processes', 'order' => $order++, 'width' => 144, 'visible' => 1],
            ['name' => 'Category', 'order' => $order++, 'width' => 84, 'visible' => 1],
            ['name' => 'Country', 'order' => $order++, 'width' => 144, 'visible' => 1],
            ['name' => 'Manufacturer', 'order' => $order++, 'width' => 140, 'visible' => 1],
            ['name' => 'Generic', 'order' => $order++, 'width' => 180, 'visible' => 1],
            ['name' => 'Form', 'order' => $order++, 'width' => 140, 'visible' => 1],
            ['name' => 'Basic form', 'order' => $order++, 'width' => 140, 'visible' => 1],
            ['name' => 'Dosage', 'order' => $order++, 'width' => 160, 'visible' => 1],
            ['name' => 'Pack', 'order' => $order++, 'width' => 110, 'visible' => 1],
            ['name' => 'MOQ', 'order' => $order++, 'width' => 144, 'visible' => 1],
            ['name' => 'Shelf Life', 'order' => $order++, 'width' => 100, 'visible' => 1],
            ['name' => 'Product category', 'order' => $order++, 'width' => 158, 'visible' => 1],
            ['name' => 'Dossier', 'order' => $order++, 'width' => 180, 'visible' => 1],
            ['name' => 'Zones', 'order' => $order++, 'width' => 60, 'visible' => 1],
            ['name' => 'Manufacturer Brand', 'order' => $order++, 'width' => 182, 'visible' => 1],
            ['name' => 'Bioequivalence', 'order' => $order++, 'width' => 124, 'visible' => 1],
            ['name' => 'Validity period patent', 'order' => $order++, 'width' => 160, 'visible' => 1],
            ['name' => 'Registered in EU', 'order' => $order++, 'width' => 138, 'visible' => 1],
            ['name' => 'Sold in EU', 'order' => $order++, 'width' => 106, 'visible' => 1],
            ['name' => 'Down payment', 'order' => $order++, 'width' => 132, 'visible' => 1],
            ['name' => 'Comments', 'order' => $order++, 'width' => 110, 'visible' => 1],
            ['name' => 'Last comment', 'order' => $order++, 'width' => 240, 'visible' => 1],
            ['name' => 'Comments Date', 'order' => $order++, 'width' => 128, 'visible' => 1],
            ['name' => 'BDM', 'order' => $order++, 'width' => 142, 'visible' => 1],
            ['name' => 'Analyst', 'order' => $order++, 'width' => 142, 'visible' => 1],
            ['name' => 'Date of creation', 'order' => $order++, 'width' => 138, 'visible' => 1],
            ['name' => 'Update Date', 'order' => $order++, 'width' => 150, 'visible' => 1],
            ['name' => 'ID', 'order' => $order++, 'width' => 72, 'visible' => 1],
        ];
    }

    private function getDefaultProcessColumns()
    {
        $order = 1;

        return [
            ['name' => 'Edit', 'order' => $order++, 'width' => 44, 'visible' => 1],
            ['name' => 'Date', 'order' => $order++, 'width' => 100, 'visible' => 1],
            ['name' => 'Country', 'order' => $order++, 'width' => 86, 'visible' => 1],
            ['name' => 'НПП/УДС', 'order' => $order++, 'width' => 84, 'visible' => 1],
            ['name' => 'Manufacturer', 'order' => $order++, 'width' => 140, 'visible' => 1],
            ['name' => 'Manuf/country', 'order' => $order++, 'width' => 114, 'visible' => 1],
            ['name' => 'BDM', 'order' => $order++, 'width' => 142, 'visible' => 1],
            ['name' => 'Analyst', 'order' => $order++, 'width' => 142, 'visible' => 1],
            ['name' => 'Prod/categ', 'order' => $order++, 'width' => 130, 'visible' => 1],
            ['name' => 'Generic', 'order' => $order++, 'width' => 180, 'visible' => 1],
            ['name' => 'Form', 'order' => $order++, 'width' => 140, 'visible' => 1],
            ['name' => 'Dose', 'order' => $order++, 'width' => 160, 'visible' => 1],
            ['name' => 'Pack', 'order' => $order++, 'width' => 110, 'visible' => 1],

            ['name' => 'MAH', 'order' => $order++, 'width' => 140, 'visible' => 1],
            ['name' => 'TM ENG', 'order' => $order++, 'width' => 140, 'visible' => 1],
            ['name' => 'TM RUS', 'order' => $order++, 'width' => 140, 'visible' => 1],

            ['name' => 'Price 1', 'order' => $order++, 'width' => 140, 'visible' => 1],
            ['name' => 'Price 2', 'order' => $order++, 'width' => 140, 'visible' => 1],
            ['name' => 'Currency', 'order' => $order++, 'width' => 140, 'visible' => 1],
            ['name' => 'USD', 'order' => $order++, 'width' => 140, 'visible' => 1],
            ['name' => 'Agreed', 'order' => $order++, 'width' => 150, 'visible' => 1],
            ['name' => 'Our price 2', 'order' => $order++, 'width' => 140, 'visible' => 1],
            ['name' => 'Our price 1', 'order' => $order++, 'width' => 140, 'visible' => 1],

            ['name' => 'Price increased (new price)', 'order' => $order++, 'width' => 194, 'visible' => 1],
            ['name' => 'Price increased %', 'order' => $order++, 'width' => 156, 'visible' => 1],
            ['name' => 'Price increased date', 'order' => $order++, 'width' => 174, 'visible' => 1],

            ['name' => 'Expiration date', 'order' => $order++, 'width' => 140, 'visible' => 1],
            ['name' => 'Minimum volume', 'order' => $order++, 'width' => 140, 'visible' => 1],

            ['name' => 'Product link', 'order' => $order++, 'width' => 140, 'visible' => 1],
            ['name' => 'Dossier status', 'order' => $order++, 'width' => 140, 'visible' => 1],
            ['name' => 'Year КИ/БЭ', 'order' => $order++, 'width' => 140, 'visible' => 1],
            ['name' => 'Countries КИ/БЭ', 'order' => $order++, 'width' => 140, 'visible' => 1],
            ['name' => 'ICH country КИ/БЭ', 'order' => $order++, 'width' => 140, 'visible' => 1],
            ['name' => 'Zones', 'order' => $order++, 'width' => 140, 'visible' => 1],
            ['name' => 'Additional 1', 'order' => $order++, 'width' => 140, 'visible' => 1],
            ['name' => 'Additional 2', 'order' => $order++, 'width' => 140, 'visible' => 1],

            ['name' => 'Status', 'order' => $order++, 'width' => 80, 'visible' => 1],
            ['name' => 'General status', 'order' => $order++, 'width' => 116, 'visible' => 1],

            ['name' => 'ПО date', 'order' => $order++, 'width' => 140, 'visible' => 1],
            ['name' => 'Year 1', 'order' => $order++, 'width' => 140, 'visible' => 1],
            ['name' => 'Year 2', 'order' => $order++, 'width' => 140, 'visible' => 1],
            ['name' => 'Year 3', 'order' => $order++, 'width' => 140, 'visible' => 1],

            ['name' => 'Owners', 'order' => $order++, 'width' => 154, 'visible' => 1],
            ['name' => 'Process date', 'order' => $order++, 'width' => 130, 'visible' => 1],
            ['name' => 'Days past', 'order' => $order++, 'width' => 120, 'visible' => 1],
            ['name' => 'ID', 'order' => $order++, 'width' => 90, 'visible' => 1],
        ];
    }

    private function getDefaultKvppColumns()
    {
        $order = 1;

        return [
            ['name' => 'Edit', 'order' => $order++, 'width' => 44, 'visible' => 1],
            ['name' => 'Status', 'order' => $order++, 'width' => 82, 'visible' => 1],
            ['name' => 'Country', 'order' => $order++, 'width' => 86, 'visible' => 1],
            ['name' => 'Priority', 'order' => $order++, 'width' => 106, 'visible' => 1],
            ['name' => 'Source', 'order' => $order++, 'width' => 98, 'visible' => 1],
            ['name' => 'Generic', 'order' => $order++, 'width' => 140, 'visible' => 1],
            ['name' => 'Form', 'order' => $order++, 'width' => 140, 'visible' => 1],
            ['name' => 'Basic form', 'order' => $order++, 'width' => 140, 'visible' => 1],
            ['name' => 'Dosage', 'order' => $order++, 'width' => 160, 'visible' => 1],
            ['name' => 'Pack', 'order' => $order++, 'width' => 110, 'visible' => 1],
            ['name' => 'MAH', 'order' => $order++, 'width' => 64, 'visible' => 1],
            ['name' => 'Information', 'order' => $order++, 'width' => 140, 'visible' => 1],
            ['name' => 'Comments', 'order' => $order++, 'width' => 110, 'visible' => 1],
            ['name' => 'Last comment', 'order' => $order++, 'width' => 240, 'visible' => 1],
            ['name' => 'Comments Date', 'order' => $order++, 'width' => 128, 'visible' => 1],
            ['name' => 'Date of forecast', 'order' => $order++, 'width' => 136, 'visible' => 1],
            ['name' => 'Forecast 1 year', 'order' => $order++, 'width' => 112, 'visible' => 1],
            ['name' => 'Forecast 2 year', 'order' => $order++, 'width' => 112, 'visible' => 1],
            ['name' => 'Forecast 3 year', 'order' => $order++, 'width' => 112, 'visible' => 1],
            ['name' => 'Portfolio manager', 'order' => $order++, 'width' => 150, 'visible' => 1],
            ['name' => 'Date of creation', 'order' => $order++, 'width' => 138, 'visible' => 1],
            ['name' => 'Update Date', 'order' => $order++, 'width' => 150, 'visible' => 1],
            ['name' => 'ID', 'order' => $order++, 'width' => 72, 'visible' => 1],
        ];
    }
}
