#
# Author:: Andrew Coulton (<andrew@ingenerator.com>)
# Cookbook Name:: php
# Attribute:: module_apc
#
# Configuration for mod_apc
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
default['php']['modules']['apc']['ini']['enabled'] = 1
#default['php']['modules']['apc']['ini']['shm_segments'] = 1
# This attribute causes errors in mmap mode, only define if required
default['php']['modules']['apc']['ini']['shm_size'] = '32M'
default['php']['modules']['apc']['ini']['optimization'] = 0
default['php']['modules']['apc']['ini']['num_files_hint'] = 1000
default['php']['modules']['apc']['ini']['user_entries_hint'] = 4096
default['php']['modules']['apc']['ini']['ttl'] = 0
default['php']['modules']['apc']['ini']['user_ttl'] = 0
default['php']['modules']['apc']['ini']['gc_ttl'] = 3600
default['php']['modules']['apc']['ini']['cache_by_default'] = 1
default['php']['modules']['apc']['ini']['filters'] = nil
default['php']['modules']['apc']['ini']['mmap_file_mask'] = nil
default['php']['modules']['apc']['ini']['slam_defense'] = 1
default['php']['modules']['apc']['ini']['file_update_protection'] = 2
default['php']['modules']['apc']['ini']['enable_cli'] = 0
default['php']['modules']['apc']['ini']['max_file_size'] = '1M'
default['php']['modules']['apc']['ini']['use_request_time'] = 1
default['php']['modules']['apc']['ini']['stat'] = 1
default['php']['modules']['apc']['ini']['write_lock'] = 1
default['php']['modules']['apc']['ini']['report_autofilter'] = 0
default['php']['modules']['apc']['ini']['include_once_override'] = 0
default['php']['modules']['apc']['ini']['rfc1867'] = 0
default['php']['modules']['apc']['ini']['rfc1867_prefix'] = 'upload_'
default['php']['modules']['apc']['ini']['rfc1867_name'] = 'APC_UPLOAD_PROGRESS'
default['php']['modules']['apc']['ini']['rfc1867_freq'] = 0
default['php']['modules']['apc']['ini']['rfc1867_ttl'] = 3600
default['php']['modules']['apc']['ini']['localcache'] = 0
default['php']['modules']['apc']['ini']['localcache.size'] = 512
default['php']['modules']['apc']['ini']['coredump_unmap'] = 0
default['php']['modules']['apc']['ini']['stat_ctime'] = 0
default['php']['modules']['apc']['ini']['preload_path'] = nil
default['php']['modules']['apc']['ini']['file_md5'] = 0
default['php']['modules']['apc']['ini']['canonicalize'] = 1
default['php']['modules']['apc']['ini']['lazy_functions'] = 0
default['php']['modules']['apc']['ini']['lazy_classes'] = 0