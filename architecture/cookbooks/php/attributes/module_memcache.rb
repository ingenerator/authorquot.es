#
# Author:: Andrew Coulton (<andrew@ingenerator.com>)
# Cookbook Name:: php
# Attribute:: module_memcache
#
# Configuration for mod_memcache
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
default['php']['modules']['memcache']['ini']['allow_failover'] = 1
default['php']['modules']['memcache']['ini']['max_failover_attempts'] = 20
default['php']['modules']['memcache']['ini']['chunk_size'] = 8192
default['php']['modules']['memcache']['ini']['default_port'] = 11211
default['php']['modules']['memcache']['ini']['hash_strategy'] = 'standard'
default['php']['modules']['memcache']['ini']['hash_function'] = 'crc32'
default['php']['modules']['memcache']['ini']['protocol'] = 'ascii'
default['php']['modules']['memcache']['ini']['redundancy'] = 1
default['php']['modules']['memcache']['ini']['session_redundancy'] = 2
default['php']['modules']['memcache']['ini']['compress_threshold'] = 20000