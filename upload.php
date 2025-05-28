<?php
putenv("HOME=/var/www");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $target = "/tmp/" . basename($_FILES['file']['name']);
    if (move_uploaded_file($_FILES['file']['tmp_name'], $target)) {
        echo "File uploaded. Uploading to OCI...<br>";
        $cmd = "sudo /usr/bin/oci os object put -bn bucket-20250521-1835 --file {$target} --namespace idyhabl91i8j";
        echo "<pre>" . shell_exec($cmd) . "</pre>";
    } else {
        echo "Upload failed.";
    }
}
?>
<form method="post" enctype="multipart/form-data">
  <input type="file" name="file" />
  <input type="submit" />
</form>
