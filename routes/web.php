<?php

use App\Http\Controllers\CategoriaController;
use App\Http\Controllers\ClienteController;
use App\Http\Controllers\ConfiguracionController;
use App\Http\Controllers\FacturaController;
use App\Http\Controllers\InformeController;
use App\Http\Controllers\PanelController;
use App\Http\Controllers\ProductoController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProveedorController;
use App\Http\Controllers\StockController;
use App\Http\Controllers\UsuarioController;
use App\Http\Controllers\UsuarioManagementController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::group(['auth', ['role', 'admin']] ,function () {

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
    Route::get('all-categoria', [CategoriaController::class,'AllCategory']);

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


    //Cliente
    Route::resource('clientes', ClienteController::class);
    Route::get('clientes/delete/{id}', [ClienteController::class, 'destroy']);
    Route::post('clientes/update/{id}', [ClienteController::class, 'update']);
    Route::get('clientes-lista', [ClienteController::class, 'ClienteLista']);

    //Usuario

    Route::get('logout',  [UsuarioController::class, 'logout']);


    //Factura

    Route::resource('factura', FacturaController::class);
    Route::get('factura/delete/{id}', [FacturaController::class, 'destroy']);
    Route::post('factura/update/{id}', [FacturaController::class, 'update']);
    Route::get('factura-lista', [FacturaController::class, 'FacturaLista']);
    Route::get('get/invoice/number', [FacturaController::class, 'getLastInvoice']);

    //Informe
    Route::get('informe', function () {
        return Inertia::render('Informe/Index');
    })->name('informe.index');

    Route::get('get-informe', function () {
        return Inertia::render('Informe/Store');
    })->name('informe.store');

    Route::get('print-informe', function (){
        return Inertia::render('Informe/Print');
    })->name('informe.print');

    //Manejo Usuarios

    Route::resource('usuario', UsuarioManagementController::class);
    Route::get('usuario/delete/{id}', [UsuarioManagementController::class, 'destroy']);
    Route::post('usuario/update/{id}', [UsuarioManagementController::class, 'update']);
    Route::get('usuario-lista', [UsuarioManagementController::class, 'UsuarioLista']);

    //Configuracion
    Route::get('password-change', function (){
        return Inertia::render('Password/Index');
    })->name('password.index');

    Route::post('password-change', function (){
        return Inertia::render('Password/Store');
    })->name('password.store');

    //Panel
    Route::get('PanelController', [PanelController::class, 'index']);
    Route::get('info-box', [PanelController::class, 'InfoBox']);

});

Route::group(['auth', ['role', 'gerente']],function () {

    //Productos
    Route::resource('productos', ProductoController::class);
    Route::get('productos/update/{id}', [ProductoController::class, 'update']);
    Route::get('producto-lista', [ProductoController::class, 'ProductoLista']);
    Route::get('categoria/producto/{id}', [ProductoController::class, 'productoPorCategoria']);

    //Categoria
    Route::resource('categoria', CategoriaController::class);
    Route::get('categoria/update/{id}', [CategoriaController::class,'update']);
    Route::get('categoria-lista', [CategoriaController::class,'CategoriaLista']);
    Route::get('all-categoria', [CategoriaController::class,'AllCategory']);

    //Stock
    Route::resource('stock', StockController::class);
    Route::post('stock/update/{id}',[StockController::class, 'update']);
    Route::get('stock-list', [StockController::class, 'StockList']);
    Route::get('stock-listaCan/listaCan/{id}', [StockController::class, 'StockListaCan']);
    Route::post('stock-update', [StockController::class, 'StockUpdate']);

    //Proveedor
    Route::resource('proveedor', ProveedorController::class);
    Route::post('proveedor/update/{id}', [ProveedorController::class, 'update']);
    Route::get('prooveedor-lista', [ProveedorController::class,'Proveedor']);


    //Cliente
    Route::resource('clientes', ClienteController::class);
    Route::post('clientes/update/{id}', [ClienteController::class, 'update']);
    Route::get('clientes-lista', [ClienteController::class, 'ClienteLista']);

    //Usuario
    Route::get('logout',  [UsuarioController::class, 'logout']);

    //Factura

    Route::resource('factura', FacturaController::class);
    Route::post('factura/update/{id}', [FacturaController::class, 'update']);
    Route::get('factura-lista', [FacturaController::class, 'FacturaLista']);
    Route::get('get/invoice/number', [FacturaController::class, 'getLastInvoice']);

    //Informe
    Route::get('informe', function () {
        return Inertia::render('Informe/Index');
    })->name('informe.index');

    Route::get('get-informe', function () {
        return Inertia::render('Informe/Store');
    })->name('informe.store');

    Route::get('print-informe', function (){
        return Inertia::render('Informe/Print');
    })->name('informe.print');


    //Panel
    Route::get('PanelController', [PanelController::class, 'index']);
    Route::get('info-box', [PanelController::class, 'InfoBox']);

});

Route::group(['auth', ['role', 'empleado']],function () {
    //Productos
    Route::resource('productos', ProductoController::class);
    Route::get('producto-lista', [ProductoController::class, 'ProductoLista']);
    Route::get('categoria/producto/{id}', [ProductoController::class, 'productoPorCategoria']);

    //Categoria
    Route::resource('categoria', CategoriaController::class);
    Route::get('categoria-lista', [CategoriaController::class,'CategoriaLista']);
    Route::get('all-categoria', [CategoriaController::class,'AllCategory']);

    //Stock
    Route::resource('stock', StockController::class);
    Route::get('stock-list', [StockController::class, 'StockList']);
    Route::get('stock-listaCan/listaCan/{id}', [StockController::class, 'StockListaCan']);

    //Proveedor

    Route::resource('proveedor', ProveedorController::class);
    Route::get('prooveedor-lista', [ProveedorController::class,'Proveedor']);


    //Cliente
    Route::resource('clientes', ClienteController::class);
    Route::get('clientes-lista', [ClienteController::class, 'ClienteLista']);

    //Usuario

    Route::get('logout',  [UsuarioController::class, 'logout']);


    //Factura

    Route::resource('factura', FacturaController::class);
    Route::get('factura-lista', [FacturaController::class, 'FacturaLista']);
    Route::get('get/invoice/number', [FacturaController::class, 'getLastInvoice']);

    //Informe
    Route::get('informe', function () {
        return Inertia::render('Informe/Index');
    })->name('informe.index');

    Route::get('get-informe', function () {
        return Inertia::render('Informe/Store');
    })->name('informe.store');

    Route::get('print-informe', function (){
        return Inertia::render('Informe/Print');
    })->name('informe.print');

    //Panel
    Route::get('PanelController', [PanelController::class, 'index']);
    Route::get('info-box', [PanelController::class, 'InfoBox']);

});


require __DIR__.'/auth.php';
