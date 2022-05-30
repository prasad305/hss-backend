<h1>Your Schedule Date</h1>
<table style="width: 50%">
    <tr>
        <th>Event Type</th>
        <th>Start Time</th>
        <th>End Time</th>
        <th>Start Date</th>
    </tr>
    @foreach ($remainders as $remainder)
    <tr>
        <td>{{$remainder['event_type']}}</td>
        <td>{{Carbon\Carbon::parse($remainder['from'])->format('h:i A')}}</td>

        {{-- <td>{{date('h:s A',strtotime($remainder['from']))}}</td> --}}
        {{-- <td>{{date('h:s A',strtotime($remainder['to']))}}</td> --}}
        <td>{{Carbon\Carbon::parse($remainder['to'])->format('h:i A')}}</td>
        <td>{{date('Y M,d',strtotime($remainder['date']))}}</td>
    </tr>
    @endforeach
 
</table>

<p>Thanks,</p>
{{config('app.name')}}