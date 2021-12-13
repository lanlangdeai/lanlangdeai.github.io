Centos系统



### 1.更换yum源



```bash
cd /etc/yum.repos.d 目录下，CentOS-Base.repo为全局镜像源配置，将其进行更换
mv CentOS-Base.repo CentOS-Base.repo.bak


# 查看centos版本
[root@localhost yum.repos.d]# cat /etc/redhat-release 
CentOS Linux release 7.6.1810 (Core) 

# 配置为阿里镜像源
wget -O /etc/yum.repos.d/CentOS-Base.repo http://mirrors.aliyun.com/repo/Centos-7.repo

# 设置缓存
yum makecache

# 更新镜像配置，可以看到阿里镜像源
[root@localhost yum.repos.d]# yum -y update
Loaded plugins: fastestmirror
Loading mirror speeds from cached hostfile
 * base: mirrors.aliyun.com
 * epel: mirrors.njupt.edu.cn
 * extras: mirrors.aliyun.com
 * updates: mirrors.aliyun.com
```



