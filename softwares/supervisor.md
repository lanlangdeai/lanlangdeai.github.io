# 进程管理工具之Supervisor



## 介绍

​		Supervisor是用Python开发的一套通用的进程管理程序，能将一个普通的命令行进程变为后台daemon，并监控进程状态，异常退出时能自动重启。它是通过fork/exec的方式把这些被管理的进程当作supervisor的子进程来启动，这样只要在supervisor的配置文件中，把要管理的进程的可执行文件的路径写进去即可。也实现当子进程挂掉的时候，父进程可以准确获取子进程挂掉的信息的，可以选择是否自己启动和报警。





## 开启启动

1. 添加系统服务配置文件

   ```
   vim /lib/systemd/system/supervisord.service
   ```

   

2. 添加配置项

   ```
   [Unit]
   Description=supervisord daemon
   
   [Service]
   Type=forking
   ExecStart=/bin/supervisord -c /etc/supervisord/supervisord.conf
   ExecReload=/bin/supervisorctl reload
   ExecStop=/bin/supervisorctl shutdown
   KillMode=process
   Restart=on-failure
   RestartSec=30s
   
   [Install]
   WantedBy=multi-user.target
   ```

3. 说明与注意点

   ```
   RestartSec: 开机多久之后启动
   
   ```

4. 常用命令

   ```
   a)开启服务
   systemctl enable supervisord
   ```

   







