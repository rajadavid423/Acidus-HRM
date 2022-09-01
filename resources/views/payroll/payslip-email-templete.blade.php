<html>
<body>
<h3>Hi, {{ $name  }}</h3>

<h4>            Good day! </h4>

<h4 style="text-indent: 50px;">   Herewith attached is the payslip for the month of {{ \Carbon\Carbon::parse($month)->format('F Y') }} for your reference.
    Please meet me in person if you need any clarification.</h4>

<p>Thank you!<br>Regards,<br>Acidus</p>
</body>
</html>
