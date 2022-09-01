<html>
<body>
<h3>Hi,</h3>

<h4> Good day! </h4>

<h4 style="text-indent: 50px;">  Leave Applied Notification , </h4>

<p> Your Applied leave from ({{ $startDate }}) to ({{$endDate}}).</p>
<p> Leave Type     : {{ $Leavetype }}</p>
<p> Leave Duration : {{ $duration }}</p>
<p> No Of Days     : {{ $no_of_days }}</p>
<p> Reason         : {{ $reason }}</p>
<p> Team           : {{ $team }}   </p>
<p> Status           : {{ __('Approved') }}   </p>
<p>Thank you!<br>Regards,<br>Acidus</p>
</body>
</html>
