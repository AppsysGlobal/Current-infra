<?php
putenv("HOME=/var/www");
putenv("OCI_CLI_AUTH=api_key");

$bucket = "bucket-20250521-1835";
$namespace = "idyhabl91i8j";
$config_path = "/var/www/.oci/config";
$upload_status = "";
$cli_output = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $target = "/tmp/" . basename($_FILES['file']['name']);

    if (move_uploaded_file($_FILES['file']['tmp_name'], $target)) {
        $upload_status = "✅ File uploaded to server. Now uploading to Object Storage...";

        $cmd = "sudo /home/ubuntu/bin/oci os object put --bucket-name $bucket --file " . escapeshellarg($target) . " --namespace $namespace --config-file $config_path";
        $cli_output = shell_exec($cmd);
    } else {
        $upload_status = "❌ File upload failed.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Upload to OCI</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f9f9f9;
            padding: 50px;
        }
        .upload-box {
            background: #fff;
            border-radius: 10px;
            padding: 30px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
            width: 450px;
            margin: auto;
            text-align: center;
        }
        .status {
            margin-top: 20px;
            font-size: 16px;
        }
        .custom-file-upload {
            display: inline-block;
            padding: 12px 20px;
            cursor: pointer;
            background-color: #e6f2ff;
            border: 2px dashed #0073e6;
            border-radius: 6px;
            font-size: 16px;
            color: #0073e6;
            transition: 0.3s;
        }
        .custom-file-upload:hover {
            background-color: #cce6ff;
        }
        input[type="file"] {
            display: none;
        }
        input[type="submit"] {
            margin-top: 20px;
            padding: 12px 24px;
            background: #0073e6;
            color: white;
            border: none;
            border-radius: 6px;
            font-size: 16px;
            cursor: pointer;
        }
        input[type="submit"]:hover {
            background: #005bb5;
        }
        pre {
            text-align: left;
            background: #f4f4f4;
            padding: 10px;
            border-radius: 6px;
            overflow-x: auto;
        }
    </style>
</head>
<body>
    <div class="upload-box">
        <h2>📤 Upload File to OCI Object Storage</h2>

        <form method="post" enctype="multipart/form-data">
            <label class="custom-file-upload">
                <input type="file" name="file" required />
                📁 Select File
            </label><br>
            <input type="submit" value="🚀 Upload" />
        </form>

        <?php if ($upload_status): ?>
            <div class="status"><?= htmlspecialchars($upload_status) ?></div>
        <?php endif; ?>

        <?php if ($cli_output): ?>
            <pre><?= htmlspecialchars($cli_output) ?></pre>
        <?php endif; ?>
    </div>
</body>
</html>
