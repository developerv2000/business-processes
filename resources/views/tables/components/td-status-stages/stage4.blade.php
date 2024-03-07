<div class="stage-periods">
    <div class="stage-periods__duration">{{ $item->status_stage_periods[3]['duration_days'] }} {{ __('days') }}</div>
    <hr class="stage-periods__hr stage-periods__hr--stage4" style="width: {{ $item->status_stage_periods[3]['line_length'] }}%">
    <div class="stage-periods__period">{{ $item->status_stage_periods[3]['start_date'] . ' - ' .  $item->status_stage_periods[3]['end_date'] }}</div>
</div>
