<?php $this->extend('layout/main')?>

<?php $this->section('title') ?>
<?php echo (isset($titulo) ? $titulo : ' Acceso '); ?>
<?php $this->endSection() ?>


<?php $this->section('content')?>

<?php $this->endSection()?>


<?php $this->section('js') ?>

<?php $this->endSection() ?>