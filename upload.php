<?php
putenv("HOME=/var/www");
putenv("OCI_CLI_AUTH=api_key");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $target = "/tmp/" . basename($_FILES['file']['name']);
    if (move_uploaded_file($_FILES['file']['tmp_name'], $target)) {
        $cmd = "sudo /home/ubuntu/bin/oci os object put -bn bucket-20250521-1835 --file {$target} --namespace idyhabl91i8j";
        $output = shell_exec($cmd);
        $message = "✅ File uploaded and sent to Object Storage.<br><pre>$output</pre>";
    } else {
        $message = "❌ Upload failed.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Fancy OCI Uploader</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://kit.fontawesome.com/a2e0e6ad50.js" crossorigin="anonymous"></script>
</head>
<body class="bg-dark text-light">
  <div class="container py-5">
    <div class="text-center mb-4">
      <h1><i class="fas fa-cloud-upload-alt"></i> OCI File Uploader</h1>
      <p class="lead">Upload your file and send to Oracle Object Storage</p>
    </div>

    <?php if (isset($message)): ?>
      <div class="alert alert-info"><?= $message ?></div>
    <?php endif; ?>

    <div class="card p-4 shadow-lg bg-light text-dark">
      <form method="post" enctype="multipart/form-data">
        <div class="mb-3">
          <label for="file" class="form-label"><i class="fas fa-file-upload"></i> Select file</label>
          <input type="file" name="file" class="form-control" id="file" required>
        </div>
        <button type="submit" class="btn btn-primary"><i class="fas fa-upload"></i> Upload</button>
      </form>
    </div>
  </div>
</body>
</html>
