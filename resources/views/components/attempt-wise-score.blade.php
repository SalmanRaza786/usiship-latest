

<div class="d-flex mb-3 mt-3  align-items-center justify-content-between">
    <div class="flex-shrink-0">
        <h5 class="mb-0 pb-1 text-decoration-underline"> {{__('translation.Attempt')}} {{$attempt->title}}</h5>
    </div>
    <div class="flex-grow-0 text-end">

        <a href="javascript:void(0);" class="badge rounded-pill border border-info text-info">Total {{$attemptWiseScore['totalQ']}} </a>
        <a href="javascript:void(0);" class="badge rounded-pill border border-success text-success">Correct {{$attemptWiseScore['correctAns']}} ({{$attemptWiseScore['correctAnsPercentage']}}%) </a>
        <a href="javascript:void(0);" class="badge rounded-pill border border-danger text-danger">Incorrect {{$attemptWiseScore['wrongAns']}} ({{$attemptWiseScore['wrongAnsPercentage']}}%) </a>
        <a href="javascript:void(0);" class="badge rounded-pill border border-primary text-primary">Pending {{$attemptWiseScore['notYetQ']}} ({{$attemptWiseScore['notYetQPercentage']}}%) </a>
    </div>
</div>
