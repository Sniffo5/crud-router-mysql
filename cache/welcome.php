<h2>Hello <?= htmlspecialchars($name) ?></h2>

<?php if($age>18): ?> 
<p>You can drink</p>
<?php endif;?> 

<?php foreach($grades as $g): ?> 
<p><?= htmlspecialchars($g) ?></p>
<?php endforeach;?> 