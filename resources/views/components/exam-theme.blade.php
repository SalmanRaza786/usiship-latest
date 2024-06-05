@php
    $activeTheme=  $appInfo->where('key','theory_practice_theme')->pluck('value')->first()
@endphp
@php
    $CurrentLang=App::currentLocale();
@endphp
    <!--{{$CurrentLang;}}-->
@if($CurrentLang == 'ur')
    <style>
        @import "https://fonts.googleapis.com/css2?family=Noto+Nastaliq+Urdu";
        .question-text, .option-text, .btn, p {
            font-family: 'Noto Nastaliq Urdu';
        }
        :is(.h1,.h2,.h3,.h4,.h5,.h6,h1,h2,h3,h4,h5,h6){
            font-family: 'Noto Nastaliq Urdu';
        }
    </style>
@endif
@if($CurrentLang == 'ae')
    <style>
        @import "https://fonts.googleapis.com/css2?family=IBM+Plex+Sans+Arabic";
        .question-text, .option-text, .btn, p{
            font-family: 'IBM Plex Sans Arabic';
        }
        :is(.h1,.h2,.h3,.h4,.h5,.h6,h1,h2,h3,h4,h5,h6){
            font-family: 'IBM Plex Sans Arabic';
        }
    </style>
@endif
@if($activeTheme==1)

    <style>
        .default-class{
            border-radius: 5px !important;
            border: 5px solid #000;
            background-color: #653b13;
            width: 75px;
            height: 75px;
            opacity: 1 !important;
        }
        .correct-answer{
            opacity: 1 !important;
            border-color: #000 !important;
            background-color: #00d5b8 !important;
            background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 20 20'%3e%3cpath fill='none' stroke='%23fff' stroke-linecap='round' stroke-linejoin='round' stroke-width='3' d='M6 10l3 3l6-6'/%3e%3c/svg%3e")!important;
        }
        .incorrect-answer{
            opacity: 1 !important;
            background-color: #f32020 !important;
            border-color: #000 !important;
            background-image: url("data:image/svg+xml,%3Csvg width='150' height='150' viewBox='0 0 30 30' fill='none' xmlns='http://www.w3.org/2000/svg'%3E%3Crect x='9.39844' y='20.7144' width='16' height='3.66667' rx='1.33333' transform='rotate(-45 9.39844 20.7144)' fill='white'/%3E%3Crect x='11.2852' y='9.40039' width='16' height='3.66667' rx='1.33333' transform='rotate(45 11.2852 9.40039)' fill='white'/%3E%3C/svg%3E") !important;
        }

        .question-image {
            vertical-align: top;
            transform-origin: top;
            -webkit-transition: 0.4s ease;
            transition: 0.4s ease;
        }

        .question-image:hover {
            transform: scale(2);
        }

        .content-en .option-question-image {
            vertical-align: top;
            transform-origin: left;
            -webkit-transition: 0.4s ease;
            transition: 0.4s ease;
            margin-left: 15px;
        }

        .content-en .option-question-image:hover {
            transform: scale(2);
        }

        .content-ae .option-question-image, .content-ur .option-question-image {
            vertical-align: top;
            transform-origin: right;
            -webkit-transition: 0.4s ease;
            transition: 0.4s ease;
        }

        .content-ae .option-question-image:hover, .content-ur .option-question-image:hover {
            transform: scale(2);
        }


    </style>
@endif

@if($activeTheme==2)
    <style>

        .default-class {
            border-radius: 5px !important;
            border: 5px solid #000;
            background-color: #653b13 !important;
            width: 75px;
            height: 75px;
            opacity: 1 !important;
        }
        .incorrect-answer {
            opacity: 1 !important;
            border-color: #f32020 !important;
            background-image: none !important;
            background-color: #653b13b3 !important;
        }
        .correct-answer {
            opacity: 1 !important;
            border-color: #0ab32a !important;
            background-image: none !important;
        }
        .question-image {
            vertical-align: top;
            transform-origin: top;
            -webkit-transition: 0.4s ease;
            transition: 0.4s ease;
        }

        .question-image:hover {
            transform: scale(2);
        }

        .content-en .option-question-image {
            vertical-align: top;
            transform-origin: left;
            -webkit-transition: 0.4s ease;
            transition: 0.4s ease;
            margin-left: 15px;
        }

        .content-en .option-question-image:hover {
            transform: scale(2);
        }

        .content-ae .option-question-image, .content-ur .option-question-image {
            vertical-align: top;
            transform-origin: right;
            -webkit-transition: 0.4s ease;
            transition: 0.4s ease;
        }

        .content-ae .option-question-image:hover, .content-ur .option-question-image:hover {
            transform: scale(2);
        }


    </style>
@endif

@if($activeTheme==3)
    <style>
        .question-image {
            vertical-align: top;
            transform-origin: top;
            -webkit-transition: 0.4s ease;
            transition: 0.4s ease;
        }

        .question-image:hover {
            transform: scale(2);
        }

        .default-class {
            border-radius: 5px !important;
            border: 5px solid #000000 !important;
            background-color: #623413 !important;
            width: 75px;
            height: 75px;
            opacity: 1 !important;
        }
        .correct-answer {
            opacity: 1 !important;
            background-image: none !important;
        }
        .incorrect-answer {
            border-color: #000000 !important;
            background-image: none !important;
            background-color: #623413 !important;
        }
        .incorrect-answer-title {
            color: #f32020 !important;
        }
        .correct-answer-title {
            color: #0ab32a !important;
        }

        .content-en .option-question-image {
            vertical-align: top;
            transform-origin: left;
            -webkit-transition: 0.4s ease;
            transition: 0.4s ease;
            margin-left: 15px;
        }

        .content-en .option-question-image:hover {
            transform: scale(2);
        }

        .content-ae .option-question-image, .content-ur .option-question-image {
            vertical-align: top;
            transform-origin: right;
            -webkit-transition: 0.4s ease;
            transition: 0.4s ease;
        }

        .content-ae .option-question-image:hover, .content-ur .option-question-image:hover {
            transform: scale(2);
        }



    </style>
@endif
