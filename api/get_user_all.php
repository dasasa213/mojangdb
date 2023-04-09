<?php
// MySQLへの接続設定が記述されたファイルを読み込む
require_once 'database.php';

// MySQLへ接続する
$mysqli = new mysqli($host, $username, $password, $dbname);

// 接続エラーの確認
if ($mysqli->connect_error) {
    error_log('MySQL接続エラー：' . $mysqli->connect_error);
    exit();
}

// userテーブルから全件取得する
$sql = 'SELECT * FROM user';
$result = $mysqli->query($sql);

// クエリー実行エラーの確認
if (!$result) {
    error_log('MySQLクエリー実行エラー：' . $mysqli->error);
    exit();
}

// 結果を連想配列で取得する
$data = array();
while ($row = $result->fetch_assoc()) {
    $data[$row['userid']] = $row['username'];
}

// 結果をJSON形式で返す
header('Content-Type: application/json');
echo json_encode($data);

// MySQLとの接続を切断する
$mysqli->close();
?>