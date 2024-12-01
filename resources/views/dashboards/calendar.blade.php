@vite('resources/js/components/dashboards/calendar.js')

@extends('components.dashboards.dashboard-layout')

@section('name')
    <div id="title" class="font-noto text-xl md:text-3xl font-bold">
        <h1>Planifica tus citas</h1>
    </div>
    <div id="calendar"
        class="w-[90%] h-[31rem] pb-4 mb-4 px-1 xl:px-4 md:h-[62rem] xl:h-[40rem] 2xl:h-[50rem] 2xl:w-3/4 
        lg:h-[800px] overflow-scroll text-xs/relaxed md:text-lg font-noto border-2 border-black
        bg-purple-500 text-white">
    </div>
@endsection
1