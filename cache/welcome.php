<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome.php view</title>
</head>
<body>

    <h2>Hello <?= htmlspecialchars($name) ?></h2>

    <?php if($age>18): ?> 
        <p>You can drink</p>
    <?php endif;?> 
    
    <?php foreach($grades as $g): ?> 
        <p><?= htmlspecialchars($g) ?></p>
    <?php endforeach;?> 


</body>
</html>