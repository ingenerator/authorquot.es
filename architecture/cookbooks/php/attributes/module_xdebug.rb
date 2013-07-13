#
# Author:: Andrew Coulton (<andrew@ingenerator.com>)
# Cookbook Name:: php
# Attribute:: module_xdebug
#
# Configuration for module_xdebug
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
default['php']['modules']['xdebug']['as_zend_extension'] = true
default['php']['modules']['xdebug']['ini']['auto_trace'] = 0
default['php']['modules']['xdebug']['ini']['cli_color'] = 0
default['php']['modules']['xdebug']['ini']['collect_assignments'] = 0
default['php']['modules']['xdebug']['ini']['collect_includes'] = 1
default['php']['modules']['xdebug']['ini']['collect_params'] = 0
default['php']['modules']['xdebug']['ini']['collect_return'] = 0
default['php']['modules']['xdebug']['ini']['collect_vars'] = 0
default['php']['modules']['xdebug']['ini']['coverage_enable'] = 1
default['php']['modules']['xdebug']['ini']['default_enable'] = 1
default['php']['modules']['xdebug']['ini']['dump_globals'] = 1
default['php']['modules']['xdebug']['ini']['dump_once'] = 1
default['php']['modules']['xdebug']['ini']['dump_undefined'] = 0
default['php']['modules']['xdebug']['ini']['extended_info'] = 1
default['php']['modules']['xdebug']['ini']['file_link_format'] = nil
#default['php']['modules']['xdebug']['ini']['idekey'] = *complex - see details*
default['php']['modules']['xdebug']['ini']['manual_url'] = 'http://www.php.net'
default['php']['modules']['xdebug']['ini']['max_nesting_level'] = 100
default['php']['modules']['xdebug']['ini']['overload_var_dump'] = 1
default['php']['modules']['xdebug']['ini']['profiler_append'] = 0
default['php']['modules']['xdebug']['ini']['profiler_enable'] = 0
default['php']['modules']['xdebug']['ini']['profiler_enable_trigger'] = 0
default['php']['modules']['xdebug']['ini']['profiler_output_dir'] = '/tmp'
default['php']['modules']['xdebug']['ini']['profiler_output_name'] = 'cachegrind.out.%p'
default['php']['modules']['xdebug']['ini']['remote_autostart'] = 0
default['php']['modules']['xdebug']['ini']['remote_connect_back'] = 0
default['php']['modules']['xdebug']['ini']['remote_cookie_expire_time'] = 3600
default['php']['modules']['xdebug']['ini']['remote_enable'] = 0
default['php']['modules']['xdebug']['ini']['remote_handler'] = 'dbgp'
default['php']['modules']['xdebug']['ini']['remote_host'] = 'localhost'
default['php']['modules']['xdebug']['ini']['remote_log'] = nil
default['php']['modules']['xdebug']['ini']['remote_mode'] = 'req'
default['php']['modules']['xdebug']['ini']['remote_port'] = 9000
default['php']['modules']['xdebug']['ini']['scream'] = 0
default['php']['modules']['xdebug']['ini']['show_exception_trace'] = 0
default['php']['modules']['xdebug']['ini']['show_local_vars'] = 0
default['php']['modules']['xdebug']['ini']['show_mem_delta'] = 0
default['php']['modules']['xdebug']['ini']['trace_enable_trigger'] = 0
default['php']['modules']['xdebug']['ini']['trace_format'] = 0
default['php']['modules']['xdebug']['ini']['trace_options'] = 0
default['php']['modules']['xdebug']['ini']['trace_output_dir'] = '/tmp'
default['php']['modules']['xdebug']['ini']['trace_output_name'] = 'trace.%c'
default['php']['modules']['xdebug']['ini']['var_display_max_children'] = 128
default['php']['modules']['xdebug']['ini']['var_display_max_data'] = 512
default['php']['modules']['xdebug']['ini']['var_display_max_depth'] = 3

