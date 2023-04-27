# Script to read Kamstrup Multical 302/402 Heat Meter via MBUS interface into Domoticz

Original code from https://gathering.tweakers.net/forum/list_messages/1692881/4

Interfaced using https://www.packom.net/m-bus-master-hat/

Tested on Domoticz 2021.1 and 2023.1

Required  libmbus, WiringPi and PHP


sudo apt install git libtool autoconf cmake build-essential php php-xml


git clone https://github.com/WiringPi/WiringPi.git

./build


git clone https://github.com/rscada/libmbus

cd libmbus

./build.sh


sudo make install

export LD_LIBRARY_PATH=/usr/local/lib

build/bin/mbus-serial-scan -b 2400 /dev/ttyAMA0


