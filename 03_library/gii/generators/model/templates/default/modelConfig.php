<?php
/**
 * This is the template for generating the model class of a specified table.
 * - $this: the ModelCode object
 * - $tableName: the table name for this class (prefix is already removed if necessary)
 * - $modelClass: the model class name
 * - $columns: list of table columns (name=>CDbColumnSchema)
 * - $labels: list of attribute labels (name=>label)
 * - $rules: list of validation rules
 * - $relations: list of relations (name=>relation declaration)
 */
?>

<?php echo "<?php\n"; ?>

return array(
    'tableName' => '<?php echo $tableName; ?>',
    'rules' => array(
    <?php foreach($rules as $rule): ?>
        <?php echo $rule.",\n"; ?>
    <?php endforeach; ?>
        // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('<?php echo implode(', ', array_keys($columns)); ?>', 'safe', 'on'=>'search'),
    ),

    'relations' => array(
<?php foreach($relations as $name=>$relation): ?>
    <?php echo "'$name' => $relation,\n"; ?>
<?php endforeach; ?>
    ),

    'attributeLabels' => array(
    <?php foreach($labels as $name=>$label): ?>
        <?php echo "'$name' => '$label',\n"; ?>
    <?php endforeach; ?>
),

<?php if($connectionId!='db'):?>
    'DbConnection' => Yii::app()-><?php echo $connectionId ?>,
<?php endif?>
);