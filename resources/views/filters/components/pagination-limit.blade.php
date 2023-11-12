<x-form.group label="{{ __('Items per page') }}">
    <select class="selectize-singular" name="paginationLimit" placeholder="{{ __('Not selected') }}">
        <option value="10" @selected($params['paginationLimit'] == 10)>10</option>
        <option value="20" @selected($params['paginationLimit'] == 20)>20</option>
        <option value="30" @selected($params['paginationLimit'] == 30)>30</option>
        <option value="50" @selected($params['paginationLimit'] == 50)>50</option>
        <option value="80" @selected($params['paginationLimit'] == 80)>80</option>
        <option value="100" @selected($params['paginationLimit'] == 100)>100</option>
    </select>
</x-form.group>
