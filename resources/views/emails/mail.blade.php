<!DOCTYPE html>
<html>

<head>
  <title>Ads API</title>
</head>

<body>
  <h1>{{ $details[0]['title'] }}</h1>

  Hi, {{ $details[0]['advertiser'] }}

  <p>You have {{ $details[0]['count'] }} Ads for tomorrow.
    <br>
    @foreach($details as $detail)
    {{ $detail['ads_title'] . ','}}
    @endforeach
  </p>

  <p>Thank you</p>

</body>

</html>