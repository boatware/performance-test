#!/bin/bash

# If you would like to do some extra provisioning you may
# add any commands you wish to this file and they will
# be run after the Homestead machine is provisioned.
#
# If you have user-specific configurations you would like
# to apply, you may also create user-customizations.sh,
# which will be run after this script.


# If you're not quite ready for the latest Node.js version,
# uncomment these lines to roll back to a previous version

# Remove current Node.js version:
#sudo apt-get -y purge nodejs
#sudo rm -rf /usr/lib/node_modules/npm/lib
#sudo rm -rf //etc/apt/sources.list.d/nodesource.list

# Install Node.js Version desired (i.e. v13)
# More info: https://github.com/nodesource/distributions/blob/master/README.md#debinstall
#curl -sL https://deb.nodesource.com/setup_18.x | sudo -E bash -
#sudo apt-get install -y nodejs

# Install Go
wget https://go.dev/dl/go1.19.1.linux-amd64.tar.gz
sudo rm -rf /usr/local/go && sudo tar -C /usr/local -xzf go1.19.1.linux-amd64.tar.gz
rm go1.19.1.linux-amd64.tar.gz
if [[ ! $(cat ~/.bashrc | grep /usr/local/go/bin) ]]; then
    echo "export PATH=\$PATH:/usr/local/go/bin" >> /home/vagrant/.bashrc
    source /home/vagrant/.bashrc
fi

# @fixme: Somehow the installation of go cannot be found. 
# However, if you login via "vagrant ssh" you have access to the go binary.
source /home/vagrant/.bashrc
go version || echo "Could not install Go."

# Java
sudo apt-get install -y openjdk-17-jre openjdk-17-jdk
java --version || echo "Could not install Java."

# C++11
sudo add-apt-repository -y ppa:ubuntu-toolchain-r/test
sudo apt install -y g++-11
g++-11 --version || echo "Could not install C++11"

