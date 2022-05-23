<?php
    require_once("../functions.php");
    
    force_login();

    // 统计授权信息时间
    $wanging = false;
    $express_day = 0;
    if(isset($config['identify'])){
        $pass_time = time()-$config['identify']['conn_time'];
        $express_time = $config['identify']['expires_in']-$pass_time;
        if($express_time<1296000){ //有效期小于15天，给出警告
            $wanging = true;
            $express_day = number_format($express_time/3600/24, 2);
        }
    }
?>
<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>管理系统 | bp3</title>
    <link href="../favicon.ico" rel="shortcut icon" />
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="../css/bootstrap.min.css" rel="stylesheet">
    <script src="../js/jquery.min.js"></script>
    <script src="../js/bootstrap.min.js"></script>
    <link href="../fonts/font-awesome-4.7.0/css/font-awesome.min.css" rel="stylesheet"/>
    <script src="../js/functions.js"></script>
</head>
<body style="background-color:rgb(231,231,231);">
 
    <header >
    <nav class="navbar navbar-default">
      <div class="container-fluid">
        <!-- Brand and toggle get grouped for better mobile display -->
        <div class="navbar-header">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand manager" href="./">管理系统</a>
        </div>
    
        <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
         <ul class="nav navbar-nav">
          </ul>
          <ul class="nav navbar-nav">
            <li class=""><a href="./file.php">文件管理<i class="fa fa-th-large" aria-hidden="true"></i><span class="sr-only">(current)</span></a></li>
            <li><a href="./settings.php">修改设置<i class="fa fa-cog"></i></a></li>
            <li><a href="./help.php">帮助与支持<i class="fa fa-question-circle" aria-hidden="true"></i></a></li>
          </ul>
          <ul class="nav navbar-nav navbar-right">
            <li><a href="../">前台<i class="fa fa-home"></i></a></li>
            <li><a href="./logout.php">注销<i class="fa fa-sign-out" aria-hidden="true"></i></i></a></li>
          </ul>
        </div><!-- /.navbar-collapse -->
      </div><!-- /.container-fluid -->
    </nav>
  
    </div>
    </header>
 <main  >
    <div class="container">
        <div class="row">
            <div class="col-xs-6">
                <h2>连接说明</h2>
            </div>
            <div class="col-xs-6">
                <h2><a id="link"  href="<?php echo $connect_grant_url;?>">获取授权</a></h2>
            </div>
        </div>
        <div>
        <p>本程序需要连接到百度网盘。</p>
        <p>如果您是首次配置，请点击<b>获取授权</b>（如已授权则覆盖原授权信息），登录百度账号以完成授权（30天有效期）</p>
        <p>访问任何页面，程序都会自动检测token有效期并智能刷新，如果你的网站没有任何流量，需30天后再次点击授权。</p>
    <?php if($wanging){ ?>
        <div class="text-danger">
            <P>警告，我们发现您的系统有些异常，您当前授权信息只有<?php echo $express_day;?>天。</P>
            <p>这说明系统自动刷新access_token出现了异常，您可能还未授权，或使用了第三方授权系统且该系统已无法使用。</p>
        </div>
    <?php } ?>
        <p>一般来说，如果您的站点正常使用，一般不会出现token失效的情况。</p>
        <p></p>
        <p>在完成授权后，在下方会自动获取你的百度基础信息。</p>
        </div>

        <div class="row">
            <div class="col-xs-12">
                <h2>百度信息</h2>
                <p>以下，是当前正在使用的百度账户信息</p>
            </div>
        </div>
        
        <div class="bs-example" data-example-id="bordered-table">
            <table class="table table-bordered">
              <thead>
                <tr>
                  <th></th>
                  <th>项目</th>
                  <th>数据</th>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <th scope="row">1</th>
                  <td>百度名称</td>
                  <td id="basic_baidu_name"><?php echo $baidu_name;?></td>
                </tr>
                <tr>
                  <th scope="row">2</th>
                  <td>网盘昵称</td>
                  <td id="basic_netdisk_name"><?php echo $netdisk_name;?></td>
                </tr>
                <tr>
                  <th scope="row">3</th>
                  <td>百度id</td>
                  <td id="basic_uk"><?php echo $uk;?></td>
                </tr>
                <tr>
                  <th scope="row">4</th>
                  <td>网盘会员</td>
                  <td id="basic_vip_type"><?php echo m_str_vip($vip_type);?></td>
                </tr>
              </tbody>
            </table>
          </div><!-- table-example -->
        <div class="row">
            <div class="col-xs-12">
                <h2>绑定登录账户 <a class="pointer" onclick="copy_basic()">复制上面</a> <a href="<?php echo $bind_account_grant_url;?>">快速绑定</a></h2>
                <p>为了系统安全，bp3账户如果连续错误3次将会被锁定，此时只能ftp编辑配置信息恢复</p>
                <p>推荐您绑定一个百度登录账户，bp3账户被封禁时可使用此账户解锁，也可用于直接登录</p>
            </div>
        </div>
        <div class="bs-example" data-example-id="bordered-table">
            <table class="table table-bordered">
              <thead>
                <tr>
                  <th></th>
                  <th>项目</th>
                  <th>数据</th>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <th scope="row">1</th>
                  <td>百度名称</td>
                  <td><?php echo $a_baidu_name;?></td>
                </tr>
                <tr>
                  <th scope="row">2</th>
                  <td>网盘昵称</td>
                  <td><?php echo $a_netdisk_name;?></td>
                </tr>
                <tr>
                  <th scope="row">3</th>
                  <td>百度id</td>
                  <td><?php echo $a_uk;?></td>
                </tr>
                <tr>
                  <th scope="row">4</th>
                  <td>网盘会员</td>
                  <td><?php echo m_str_vip($a_vip_type);?></td>
                </tr>
              </tbody>
            </table>
          </div><!-- table-example -->
          <p>注意：不要泄露你的access_token，以免带来不必要的麻烦。</p>
          <p>注意：开启百度登录时，需要开放授权系统给访客（请查看设置页面）</p>
          <p>如有bug，请反馈至github或qq交流群：1150064636</p>
          <p>退出时，请注销！！！</p>
    </div>
</main>
<footer class="footer" style="background-color:black">
      <div class="container">
            <p class="text-center" style="color:#9d9d9d;margin-top:15px;">Copyright © bp3 <?php echo date('Y')?></p>
      </div>
</footer>
<style>
    .manager{background-color:#e7e7e7;}
    html {
      position: relative;
      min-height: 100%;
    }
    body {
      margin-bottom: 50px; /* Margin bottom by footer height */
    }
    .footer {
      position: absolute;
      bottom: 0;
      width: 100%;
      height: 50px; /* Set the fixed height of the footer here */
      background-color: #f5f5f5;
    }
    .pointer{
        cursor: pointer;
    }
</style>
<script>
    function copy_basic(){
        let check = confirm("你将使用上面的信息作为登录信息");
        if(check){
            // 直接发送请求，后台自动实现更新
            $.post("../controller/copy_basic.php",{"copy":"1"},function(data){
                if(data.errno==0){
                    message("已复制成功","success");
                    lazy_reload();
                }else{
                    message("复制失败","error");
                }
            },"json");
        }
    }
</script>
</body>
</html>