<?php if ($showLabel && $showField && !$options['is_child']): ?>
<div <?= $options['wrapperAttrs'] ?> >
<?php endif; ?>

    <?php if ($showLabel): ?>
    <?= Form::label($name, $options['label'], $options['label_attr']) ?>
    <?php endif; ?>

    <?php if ($showField): ?>
    <?= Form::input($type, $name, $options['default_value'], $options['attr']) ?>
    <?php endif; ?>

    <?php if ($showError && isset($errors)): ?>
        <?= $errors->first(array_get($options, 'real_name', $name), '<div '.$options['errorAttrs'].'>:message</div>') ?>
    <?php endif; ?>

<?php if ($showLabel && $showField && !$options['is_child']): ?>
</div>
<?php endif; ?>
