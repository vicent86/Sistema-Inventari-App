<?php

use App\Http\Controllers\CategoriaController;
use App\Http\Controllers\ClienteController;
use App\Http\Controllers\ConfiguracionController;
use App\Http\Controllers\EmpresaController;
use App\Http\Controllers\FacturaController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\InformeController;
use App\Http\Controllers\PanelController;
use App\Http\Controllers\ProductoController;
use App\Http\Controllers\ProveedorController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\StockController;
use App\Http\Controllers\UsuarioController;
use App\Http\Controllers\UsuarioManagementController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [HomeController::class, 'index'])->name('home');

Route::group(['middleware' => ['auth', 'check.permission']], function () {
    //Productos
    Route::resource('productos', ProductoController::class);
    Route::get('productos/delete/{id}', [ProductoController::class, 'destroy']);
    Route::get('productos/update/{id}', [ProductoController::class, 'update']);
    Route::get('producto-lista', [ProductoController::class, 'ProductoLista']);
    Route::get('categoria/producto/{id}', [ProductoController::class, 'productoPorCategoria']);

    //Categoria
    Route::resource('categoria', CategoriaController::class);
    Route::get('categoria/delete/{id}', [CategoriaController::class,'destroy']);
    Route::get('categoria/update/{id}', [CategoriaController::class,'update']);
    Route::get('categoria-lista', [CategoriaController::class,'CategoriaLista']);
    Route::get('all-categoria', [CategoriaController::class,'AllCategoria']);

    //Stock
    Route::resource('stock', StockController::class);
    Route::get('stock/delete/{id}', [StockController::class, 'destroy']);
    Route::post('stock/update/{id}',[StockController::class, 'update']);
    Route::get('stock-list', [StockController::class, 'StockList']);
    Route::get('stock-listaCan/listaCan/{id}', [StockController::class, 'StockListaCan']);
    Route::post('stock-update', [StockController::class, 'StockUpdate']);

    //Proveedor

    Route::resource('proveedor', ProveedorController::class);
    Route::get('proveedor/delete/{id}', [ProveedorController::class, 'destroy']);
    Route::post('proveedor/update/{id}', [ProveedorController::class, 'update']);
    Route::get('prooveedor-lista', [ProveedorController::class,'Proveedor']);

    //Role
    Route::resource('role', RoleController::class);
    Route::get('role/delete/{id}', [RoleController::class, 'destroy']);
    Route::post('role/update/{id}', [RoleController::class, 'update']);
    Route::get('role-list', [RoleController::class, 'RoleList']);
    Route::post('permission', [RoleController::class, 'Permission']);
    Route::get('usuario-role', [RoleController::class,'userRole']);
    //Cliente

    Route::resource('clientes', ClienteController::class);
    Route::get('clientes/delete/{id}', [ClienteController::class, 'destroy']);
    Route::post('clientes/update/{id}', [ClienteController::class, 'update']);
    Route::get('clientes-lista', [ClienteController::class, 'ClienteLista']);

    //Usuario

    Route::get('logout',  [UsuarioController::class, 'logout']);

    //Empresa

    Route::get('empresa-setting', [EmpresaController::class, 'index'])->name('empresa.index');
    Route::post('empresa-setting', [EmpresaController::class, 'store'])->name('empresa.store');

    //Factura

    Route::resource('factura', FacturaController::class);
    Route::get('factura/delete/{id}', [FacturaController::class, 'destroy']);
    Route::post('factura/update/{id}', [FacturaController::class, 'update']);
    Route::get('factura-lista', [FacturaController::class, 'FacturaLista']);
    Route::get('get/invoice/number', [FacturaController::class, 'getLastInvoice']);

    //Informe
    Route::get('informe', [InformeController::class, 'index'])->name('informe.index');
    Route::get('get-informe', [InformeController::class, 'store'])->name('informe.store');
    Route::get('print-informe', [InformeController::class, 'Print'])->name('informe.print');

    //Manejo Usuarios

    Route::resource('usuario', UsuarioManagementController::class);
    Route::get('usuario/delete/{id}', [UsuarioManagementController::class, 'destroy']);
    Route::post('usuario/update/{id}', [UsuarioManagementController::class, 'update']);
    Route::get('usuario-lista', [UsuarioManagementController::class, 'UsuarioLista']);

    //Configuracion
    Route::get('password-change', [ConfiguracionController::class, 'index'])->name('password.index');
    Route::post('password-change', [ConfiguracionController::class, 'store'])->name('password.store');

    //Panel
    Route::get('PanelController', [PanelController::class, 'index']);
    Route::get('info-box', [PanelController::class, 'InfoBox']);

});
