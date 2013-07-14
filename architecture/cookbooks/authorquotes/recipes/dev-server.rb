#
# Cookbook Name:: authorquotes
# Recipe:: dev-server
#
# Copyright 2012, inGenerator Ltd
#
# Licensed under the Apache License, Version 2.0 (the "License");
# you may not use this file except in compliance with the License.
# You may obtain a copy of the License at
#
#     http://www.apache.org/licenses/LICENSE-2.0
#
# Unless required by applicable law or agreed to in writing, software
# distributed under the License is distributed on an "AS IS" BASIS,
# WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
# See the License for the specific language governing permissions and
# limitations under the License.
#

# Quickly chuck in required directories
directory "/var/www" do
  owner node['apache']['user']
  group node['apache']['group']
end

link "/var/www/authorquot.es" do
  to "/vagrant"
  owner node['apache']['user']
  group node['apache']['group']
end

directory "/var/log/authorquot.es" do
  owner node['apache']['user']
  group node['apache']['group']
  mode 0700
end

node.override['apache']['listen_ports'] = [node['authorquotes']['http_port']]

# Packages
include_recipe "apt"
include_recipe "apache2"
include_recipe "apache2::mod_php5"
include_recipe "apache2::mod_rewrite"
include_recipe "authorquotes::php-standard"
include_recipe "authorquotes::virtual-host"

# Sox for image processing
package "libsox-fmt-mp3"
package "sox"

# Mysql
# Set up a local mysql server
node.default['mysql']['server_root_password'] = 'mysql'
node.default['mysql']['server_debian_password'] = 'mysql'
node.default['mysql']['server_repl_password'] = 'mysql'

include_recipe "mysql::server"

# Quick and nasty database migrations
execute "mysql -uroot -pmysql < /vagrant/architecture/cookbooks/authorquotes/db_schema.sql"
