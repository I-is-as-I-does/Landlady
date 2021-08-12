<?php
require dirname(__DIR__) . '/src/MiniJack.php';
require dirname(__DIR__) . '/src/Landlady.php';


    $addPath = 'billy';
    $altSubdomain = 'tenant';
    $store = [];

    $argms = [
        'force https true | force www true' =>[true, true],
        'force https false | force www false' =>[false, false],
        'force https true | force www false' =>[true, false],
        'force https false | force www true' =>[false, true]
    ];

    foreach($argms as $k => $argm){
        
    $Landlady = new SSITU\Landlady\Landlady(...$argm);
    
    $store[] = '<h3>'.$k.'</h3>';
    $store[] = '<pre>';
    $store[] = "<p><mark>no addPath</mark></p>";
    foreach (['protocol', 'host', 'subdomain', 'domain', 'domainLabel', 'domainUrl', 'hostLabel', 'hostUrl'] as $prop) {
        $spacer = str_repeat('.',20-strlen($prop));
        $store[] = $prop .  $spacer . $Landlady->$prop.'<br>';
    }
    $store[] = "<p><mark>with addPath</mark></p>";
    foreach (['domainLabel', 'domainUrl', 'hostLabel', 'hostUrl'] as $prop) {
        $spacer = str_repeat('.',20-strlen($prop));
        $store[] = $prop . $spacer . $Landlady->$prop($addPath).'<br>';
    }
    $store[] = "<p><mark>with altSubdomain</mark></p>";
    foreach (['altHost', 'altHostLabel', 'altHostUrl'] as $prop) {
        $spacer = str_repeat('.',20-strlen($prop));
        $store[] = $prop . $spacer . $Landlady->$prop($altSubdomain, '').'<br>';
        
    }
    $store[] = "<p><mark>with altSubdomain and addPath</mark></p>";
    foreach (['altHostLabel', 'altHostUrl'] as $prop) {
        $spacer = str_repeat('.',20-strlen($prop));
        $store[] = $prop . $spacer . $Landlady->$prop($altSubdomain, $addPath).'<br>';
    }
    $store[] = '</pre>';
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Landlady Test</title>
</head>
<body>
<?php echo implode('', $store) ?>
</body>
</html>


