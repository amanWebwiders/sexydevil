@php
$user = Auth::user();
$plan = $user->plan_id ? \App\Models\Plan::find($user->plan_id) : null;
$planEnd = $user->plan_end_date ? \Carbon\Carbon::parse($user->plan_end_date)->startOfDay() : null;
$planStart = $user->plan_start_date ? \Carbon\Carbon::parse($user->plan_start_date) : null;
$now = now();
@endphp

@if ($planEnd && $plan)
    @if ($now->between($planEnd->copy()->subDays(3), $planEnd))
    <div class="alert alert-warning">
        <strong>Your plan will expire in 3 days.</strong>Please renew to continue getting visibility.<br>
        <strong>Boost your visibility!</strong> Buy credits now to feature your ad at the top of the carousel and attract more clients. Don’t miss out!

    </div>
    @elseif ($now->greaterThanOrEqualTo($planEnd))
    <div class="alert alert-danger">
        <strong>Your plan has expired.</strong> Please renew to continue getting visibility.<br>
        <strong>Boost your visibility!</strong> Buy credits now to feature your ad at the top of the carousel and attract more clients. Don’t miss out!
    </div>

    @endif
@elseif($user->type == 2)
    <div class="alert alert-danger">
        <strong>You don’t have an active plan at the moment. Please contact us to activate your plan !!</strong></div>
@endif