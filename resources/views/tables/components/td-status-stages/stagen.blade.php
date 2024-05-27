<div class="stage-periods">
    <div class="stage-periods__duration">{{ $item->status_stage_periods[$n]['duration_days'] }} {{ __('days') }}</div>
    <hr class="stage-periods__hr stage-periods__hr--stage5" style="width: {{ $item->status_stage_periods[$n]['line_length'] }}%">
    <div class="stage-periods__period">{{ $item->status_stage_periods[$n]['start_date'] . ' - ' .  $item->status_stage_periods[$n]['end_date'] }}</div>
</div>
