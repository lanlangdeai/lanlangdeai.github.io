# Docker安装



## Linux

1. 卸载老的docker版本

```bash
sudo yum remove docker \
                  docker-client \
                  docker-client-latest \
                  docker-common \
                  docker-latest \
                  docker-latest-logrotate \
                  docker-logrotate \
                  docker-engine
```

现在安装的docker是docker-ce

2. yum安装方式

 1）安装yum工具包，提供了yum-config-manager工具，可以设置稳定的包

```bash
 sudo yum install -y yum-utils  device-mapper-persistent-data lvm2
 sudo yum-config-manager \
    --add-repo \
    https://download.docker.com/linux/centos/docker-ce.repo
    
 
 yum makecache fast
```

2) 安装docker引擎

```bash
sudo yum install docker-ce docker-ce-cli containerd.io -y
```

3)启动docker服务

```bash
sudo systemctl start docker
sudo systemctl enable docker  # 设置开机启动
```



3.Docker-compose安装

```shell
sudo curl -L "https://github.com/docker/compose/releases/download/1.29.2/docker-compose-$(uname -s)-$(uname -m)" -o /usr/local/bin/docker-compose
```

