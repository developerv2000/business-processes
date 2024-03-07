<div class="stage-periods">
    <div class="stage-periods__duration">{{ $item->status_stage_periods[2]['duration_days'] }} {{ __('days') }}</div>
    <hr class="stage-periods__hr stage-periods__hr--stage3" style="width: {{ $item->status_stage_periods[2]['line_length'] }}%">
    <div class="stage-periods__period">{{ $item->status_stage_periods[2]['start_date'] . ' - ' .  $item->status_stage_periods[2]['end_date'] }}</div>
</div>
