<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
<script src="<?= make_url("public/assets/js/global.js", true); ?>"></script>
<?php

$js = generate_script_path();

?>
<?php if (file_exists($js["server_path"])): ?>
  <script src="<?= $js["client_path"]; ?>"></script>
<?php endif; ?>

<footer class="mt-5 py-2 bg-dark text-center text-white">
  © <?= date("Y", time()); ?> Copyright: <?= PROJECT_NAME; ?>
</footer>

</body>
</html>
