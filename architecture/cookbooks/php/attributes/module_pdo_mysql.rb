#
# Author:: Andrew Coulton (<andrew@ingenerator.com>)
# Cookbook Name:: php
# Attribute:: module_pdo_mysql
#
# Configuration for mod_pdo_mysql
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
default['php']['modules']['pdo_mysql']['ini']['default_socket'] = '/tmp/mysql.sock'
default['php']['modules']['pdo_mysql']['ini']['debug'] = nil
default['php']['modules']['pdo_mysql']['ini']['cache_size'] = 2000
