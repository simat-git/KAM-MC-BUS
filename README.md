
# Script to read Kamstrup Multical 302/402 Heat Meter via MBUS interface into Domoticz

Original code from https://gathering.tweakers.net/forum/list_messages/1692881/4

Interfaced using https://www.packom.net/m-bus-master-hat/

Tested on Domoticz 2021.1 and 2023.1

Required  libmbus, WiringPi and PHP

sudo apt install git libtool autoconf cmake build-essential
sudo apt-get install php -y
sudo apt-get install php-xml

git clone https://github.com/WiringPi/WiringPi.git
./build

git clone https://github.com/rscada/libmbus
cd libmbus
./build.sh
sudo make install

export LD_LIBRARY_PATH=/usr/local/lib
build/bin/mbus-serial-scan -b 2400 /dev/ttyAMA0


add the following to /etc/rc.local

# Enable M-BUS power on HAT
gpio write 25 1

#IPv6 Disable Fixer
service procps reload


the put this in your crontab

## Read Kamstrup Multical 403 via MBUS Crontab Entry
*/1 * * * * php /home/pi/domoticz/scripts/kamstrup.php

I hope this is useful.
