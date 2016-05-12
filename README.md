# teddit
## DESCRIPTION
teddit is a platform designed to demo web application hacking. teddit
was designed to look like the popular website reddit.com.
## INSTALLATION
1. Install Ubuntu 14.04 LTS

2. Update package index and installed packages

 ```
 sudo apt-get update
 sudo apt-get upgrade
 ```

3. Install LAMP server (note the MySQL root password) and git

 ```
 sudo apt-get install git lamp-server^
 ```

4. Clone repository

 ```
 git clone https://github.com/marclaliberte/teddit.git
 ```

5. Navigate into teddit directory and run setup.sh as root

 ```
 cd /teddit
 sudo ./setup.sh
 ```

6. Set a static IP and create hosts files on applicable systems for teddit.net
