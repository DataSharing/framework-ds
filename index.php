<?php  
/*
 * @version 1.0
 -------------------------------------------------------------------------
 Framework DS
 Copyright (C) 2017 By DataSharing.

 -------------------------------------------------------------------------

 LICENSE

 This file is part of Framework DS.

 Framework DS is free; you can redistribute it and/or modify
 it under the terms of the GNU General Public License as published by
 the Free Software Foundation; either version 3 of the License, or any later version.

 Framework DS is distributed in the hope that it will be useful,
 but WITHOUT ANY WARRANTY; without even the implied warranty of
 MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 GNU General Public License for more details.

 You should have received a copy of the GNU General Public License
 along with Framework DS. If not, see <http://www.gnu.org/licenses/>.
 --------------------------------------------------------------------------
 * @author : Walid Heddaji
 * @contact : datasharing7@gmail.com
 */

session_start();   
ob_start();

//Display errors
ini_set('display_errors',1);

include(dirname(__FILE__).'/core/Check.php');
include(dirname(__FILE__).'/core/Controller.php');
include(dirname(__FILE__).'/core/App.php');

Check::__run();
$app = New app();
$app->__run();

ob_end_flush();