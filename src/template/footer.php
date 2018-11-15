<?php

$js = generate_script_path();

?>
<?php if (file_exists($js["server_path"])): ?>
  <script src="<?= $js["client_path"]; ?>"></script>
<?php endif; ?>

</body>
</html>
