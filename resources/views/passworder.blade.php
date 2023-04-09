@php
function searchArray($arr, $keyword) {
  $keyword = strtolower($keyword);
  foreach ($arr as $item) {
    if (strpos(strtolower($item['login_url']), $keyword) !== false) {
      return $item;
    }
  }
  return false;
}
if(searchArray($all, 'google')){
    $val = searchArray($all, 'google');
  //$all = searchArray($all, 'login_url');
  //echo "We smell it!";
}

var_dump($val);

foreach($val as $key => $one) {
    echo $key." - ".$one;
}

@endphp

HELLO INDIA!!!
