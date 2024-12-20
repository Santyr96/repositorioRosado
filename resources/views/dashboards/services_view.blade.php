
<div class="flex flex-col items-center gap-2">
    <h1 class="font-work text-[1rem] md:text-[2rem]"><strong>{{ $hairdresser->name }}</strong></h1>
    <h2 class="font-work md:text-[2rem]"><strong>Listado de servicios </strong></h2>
    <x-tables.service-table :services="$services" :hairdresser="$hairdresser"></x-tables.service-table>
</div>
