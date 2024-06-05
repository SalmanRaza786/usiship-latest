<div id="qoutescarouselIndicators" class="carousel slide pointer-event" data-bs-ride="carousel">
    <div class="carousel-indicators">
        <button type="button" data-bs-target="#qoutescarouselIndicators" data-bs-slide-to="0" class="active" aria-label="Slide 1" aria-current="true"></button>
        <button type="button" data-bs-target="#qoutescarouselIndicators" data-bs-slide-to="1" aria-label="Slide 2" class=""></button>
        <button type="button" data-bs-target="#qoutescarouselIndicators" data-bs-slide-to="2" aria-label="Slide 3" class=""></button>
    </div>


    <div class="carousel-inner text-center text-white-50 pb-5">
        <div class="carousel-item active">
            <p class="fs-15 fst-italic">{{($appInfo->count()>0)?$appInfo->where('key','std_slide_text')->pluck('value')->first():''}}</p>
        </div>
        <div class="carousel-item">
            <p class="fs-15 fst-italic">{{($appInfo->count()>0)?$appInfo->where('key','std_slide_text1')->pluck('value')->first():''}}</p>
        </div>
        <div class="carousel-item">
            <p class="fs-15 fst-italic">{{($appInfo->count()>0)?$appInfo->where('key','std_slide_text2')->pluck('value')->first() :''}}</p>
        </div>
    </div>

</div>

