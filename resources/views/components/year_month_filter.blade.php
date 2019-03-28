<div class="f-group">
    <label>Month: </label>
    <select data-selected="{{ $month }}" class="prettySelect select-change" name="month"
            id="SelectLm" class="form-control-sm form-control">
        @foreach($months as $i => $month)
            <option value="{{ $i }}"> {{ $month }}</option>
        @endforeach
    </select>
</div>

<div class="f-group ml-4">
    <label>Year: </label>
    <select data-selected="{{ $year }}" class="prettySelect select-change" name="year"
            id="SelectLm"
            class="form-control-sm form-control">
        @foreach($years as $year)
            <option> {{ $year }}</option>
        @endforeach

        @if(!$years)
            <option>{{ $year }}</option>
        @endif
    </select>
</div>