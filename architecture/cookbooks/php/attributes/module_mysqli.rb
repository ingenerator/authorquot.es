#
# Author:: Andrew Coulton (<andrew@ingenerator.com>)
# Cookbook Name:: php
# Attribute:: module_mysqli
#
# Configuration for mod_mysqli
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
default['php']['modules']['mysqli']['ini']['allow_local_infile'] = 1
default['php']['modules']['mysqli']['ini']['allow_persistent'] = 1
default['php']['modules']['mysqli']['ini']['max_persistent'] = -1
default['php']['modules']['mysqli']['ini']['max_links'] = -1
default['php']['modules']['mysqli']['ini']['default_port'] = 3306
default['php']['modules']['mysqli']['ini']['default_socket'] = nil
default['php']['modules']['mysqli']['ini']['default_host'] = nil
default['php']['modules']['mysqli']['ini']['default_user'] = nil
default['php']['modules']['mysqli']['ini']['default_pw'] = nil
default['php']['modules']['mysqli']['ini']['reconnect'] = 0
default['php']['modules']['mysqli']['ini']['cache_size'] = 2000