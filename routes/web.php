<?php

use App\Http\Controllers\AdminPage\ArticleAdminController;
use App\Http\Controllers\AdminPage\ArticleKategoriAdminController;
use App\Http\Controllers\AdminPage\ArticleKomentarAdminController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\AdminPage\FaqController;
use App\Http\Controllers\AdminPage\KontakController;
use App\Http\Controllers\LandingPage\HomeController;
use App\Http\Controllers\AdminPage\ProgramController;
use App\Http\Controllers\AdminPage\SejarahController;
use App\Http\Controllers\AdminPage\PimpinanController;
use App\Http\Controllers\AdminPage\StrukturController;
use App\Http\Controllers\AdminPage\TimelineController;
use App\Http\Controllers\AdminPage\VisiMisiController;
use App\Http\Controllers\LandingPage\BeritaController;
use App\Http\Controllers\LandingPage\GaleryController;
use App\Http\Controllers\AdminPage\DashboardController;
use App\Http\Controllers\AdminPage\HomeKilauController;
use App\Http\Controllers\AdminPage\TestimoniController;
use App\Http\Controllers\Auth\DashboardLoginController;
use App\Http\Controllers\LandingPage\ContactController;
use App\Http\Controllers\LandingPage\DokumenController;
use App\Http\Controllers\LandingPage\ProfileController;
use App\Http\Controllers\AdminPage\ColaborasiController;
use App\Http\Controllers\AdminPage\IklanKilauController;
use App\Http\Controllers\AdminPage\BeritaAdminController;
use App\Http\Controllers\AdminPage\GaleriAdminController;
use App\Http\Controllers\AdminPage\IklanDonasiController;
use App\Http\Controllers\AdminPage\TentangKamiController;
use App\Http\Controllers\AdminPage\DokumenAdminController;
use App\Http\Controllers\AdminPage\MitraDonaturController;
use App\Http\Controllers\AdminPage\SettingsMenuController;
use App\Http\Controllers\AdminPage\LegalitasLembagaController;
use App\Http\Controllers\AdminPage\ProgramReferallController;
use App\Http\Controllers\LandingPage\ArticlePageController;
use App\Http\Controllers\LandingPage\ArticlePageExternalController;
use App\Http\Controllers\LandingPage\PointReferallController;
use App\Http\Controllers\LandingPage\TentangKamiAdminController;

/* Route::get('/', function () {
    return redirect('beranda');
}); */


/* Authentication */
Route::get('/login', [LoginController::class, 'login'])->name('login');
Route::get('/get-users', [LoginController::class, 'getDataUsersProfile'])->name('getDataUsersProfile');
Route::post('/loginprosess', [LoginController::class, 'loginProses'])->name('loginProses');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
Route::get('/register', [LoginController::class, 'register'])->name('register');

Route::get('/dashboardkilau', [DashboardLoginController::class, 'dashboardLogin'])->name('dashboardlogin');
Route::get('/dashboardkilauwebsite', [DashboardLoginController::class, 'dashboardWebsite'])->name('dashboardWebsite');

/* Landing Page */
Route::get('/', [HomeController::class, 'home'])->name('home');
Route::get('/get-program-info', [HomeController::class, 'getProgramInfo']);
Route::get('/program/{id}/referral/{referer}', [HomeController::class, 'programReferral'])->name('program.referral');
Route::post('/donasi', [HomeController::class, 'donasi'])->name('donasi.store');
Route::post('/donasi/{id}/update-status', [HomeController::class, 'updateStatusDonasi'])->name('donasi.updateStatus');
Route::post('/midtrans-notification', [HomeController::class, 'handleMidtransCallback'])->name('midtrans.notification');

Route::get('/point-referall', [PointReferallController::class, 'pointReferall'])->name('pointreferall');
Route::post('/point-referall/withdraw',[PointReferallController::class,'storeWithdrawal'])
     ->name('referral.withdraw');

Route::get('/get-berita-users', [BeritaController::class, 'getBeritaUsers'])->name('getBeritaUsers');
// Route::get('/api/referral-point/{referer_name}', function($refererName) {
//     $data = \App\Models\ProgramReferral::where('referer_name', $refererName)->get();
//     return response()->json($data);
// });


Route::get('/tentang-kamu', [TentangKamiAdminController::class, 'tentangkami'])->name('tentangkami.landingpage');
Route::post('/testimonihome', [HomeController::class, 'testimoniCreate'])->name('testimonihome.create');

Route::get('/profil-pimpinan', [ProfileController::class, 'profilPimpinan'])->name('profilPimpinan');
Route::get('/profil-struktur', [ProfileController::class, 'profilStruktur'])->name('profilStruktur');
Route::get('/profil-sejarah', [ProfileController::class, 'profilSejarah'])->name('profilSejarah');
Route::get('/profil-visimisi', [ProfileController::class, 'profilVisiMisi'])->name('profilVisiMisi');
Route::get('/profil-legalitas', [ProfileController::class, 'profilLegalitas'])->name('profilLegalitas');
Route::get('/galery', [GaleryController::class, 'galery'])->name('galery');

Route::get('/contact', [ContactController::class, 'contact'])->name('contact');
Route::post('/contactcreate', [ContactController::class, 'contactCreate'])->name('contact.create');
Route::get('/check-nama-perusahaan', [ContactController::class, 'checkNamaPerusahaan']);
Route::get('/check-email', [ContactController::class, 'checkEmail']);

// Route::get('/berita/{id}', [BeritaController::class, 'show'])->name('berita.show');
Route::get('/berita/{judul}', [BeritaController::class, 'show'])->name('berita.show');
Route::get('/dokumen', [DokumenController::class, 'dokumen'])->name('dokumen');
// Route::get('/dokumen/share/{id}', [DokumenController::class, 'share'])->name('dokumen.share');
Route::get('/dokumen/share/{slug}',[DokumenController::class, 'share'])  ->name('dokumen.share');

// GET DATA ARTIKEL
Route::prefix('artikel')->group(function () {
    Route::get('/',        [ArticlePageController::class,'index'])->name('lp.article.index');
    Route::get('/list',    [ArticlePageController::class,'list'])->name('lp.article.list'); // ⬅️ AJAX
    Route::get('/{article:slug}', [ArticlePageController::class,'show'])   // ⬅️ ganti
         ->name('lp.article.show');
    Route::post('/artikel/{article:slug}/like',[ArticlePageController::class, 'like'])->name('lp.article.like');
    Route::get('/sidebar-latest/{kategori}',[ArticlePageController::class,'sidebarLatest'])->name('lp.article.sidebarLatest');

    // Komentar
    /* ── komentar artikel ─────────────────────────────── */
    Route::get ('/{article:slug}/komentar', [ArticlePageController::class,'komentar'])
         ->name('lp.article.comment.index');                             // GET list komentar

    Route::post('/{article:slug}/komentar', [ArticlePageController::class,'komentarStore'])
         ->name('lp.article.comment.store');    
});

Route::prefix('artikel-external')
     ->name('lp.article.external.')               // <— NAME PREFIX!
     ->group(function () {

    // Halaman list + modal
    Route::get('/',
        [ArticlePageExternalController::class, 'index'])
        ->name('index');                          // lp.article.external.index

    // AJAX list JSON
    Route::get('/list',
        [ArticlePageExternalController::class, 'list'])
        ->name('list');                           

    Route::get('/my-articles',  // url bebas
        [ArticlePageExternalController::class, 'myArticles']
    )->name('mylist');

    // ========= DETAIL (BARU) =========
    Route::get('/{id}', [ArticlePageExternalController::class, 'show'])
         ->whereNumber('id')
         ->name('show');

    // form edit (JSON untuk isi modal edit)
    Route::get('/{id}/edit', [ArticlePageExternalController::class, 'edit'])
         ->whereNumber('id')
         ->name('edit');

    // update
    Route::put('/{id}', [ArticlePageExternalController::class, 'update'])
         ->whereNumber('id')
         ->name('update'); 

    Route::get('/kategori-article',
        [ArticlePageExternalController::class,'categories'])
        ->name('kategori');

    Route::post('/upload-image-article',
               [ArticlePageExternalController::class,'uploadImage'])->name('uploadImage');

    // Store dari modal
    Route::post('/',
        [ArticlePageExternalController::class, 'store'])
        ->name('store');   
                               // lp.article.external.store
});

Route::post('/komentar/{comment}/like', [ArticlePageController::class,'komentarLike'])
     ->name('lp.comment.like');


/* GET IMAGE MITRA */
Route::get('program/mitra/{id}/image', [ProgramController::class, 'getMitraImage']);
Route::get('/get-testimonials', [HomeController::class, 'getTestimonials']);
Route::post('/upload-image', [BeritaAdminController::class, 'uploadImage'])->name('upload.image');

Route::post('/track-donasi-modal', [HomeController::class, 'trackDonasiModal'])
     ->name('track.donasi.modal');
Route::post('/track-donasi-modal-program', [HomeController::class, 'trackDonasiModalProgram'])
     ->name('track.donasi.modalprogram');

Route::get('/donasi/cek-donatur', [HomeController::class, 'cekDonatur'])
    ->name('donasi.cek-donatur');

/* Admin Page */
Route::middleware(['userAccess:admin'])->prefix('admin')->group(function () {
    
    Route::post('/upload-image', [BeritaAdminController::class, 'uploadImage'])->name('upload.image');
    Route::post('/upload-image-article',[ArticleAdminController::class, 'uploadImage'])->name('article.uploadImage');
    
    // Dashboard Route
    Route::get('/dashboard', [DashboardController::class, 'dashboard'])->name('dashboard');
    Route::get('/dashboard/filter-donasi', [DashboardController::class, 'filterDonasi'])->name('dashboard.filterDonasi');
    Route::delete('/dashboard/donasi/{id}', [DashboardController::class, 'deleteDonasi'])->name('dashboard.deleteDonasi');
    
    Route::get('/dashboard/donasi-data',   [DashboardController::class, 'donasiData'])->name('dashboard.donasiData');
    
    Route::get('/dashboard/traffic-data',
        [DashboardController::class, 'trafficData'])
        ->name('dashboard.trafficData');

    Route::prefix('article-kilau')->group(function(){
        Route::prefix('article')->group(function () {
            Route::get('/', [ArticleAdminController::class, 'index'])->name('article');
            Route::get('/list',       [ArticleAdminController::class, 'list'])->name('article.list');  
            Route::get('/show/{id}', [ArticleAdminController::class, 'showArticle'])->name('showArticle');      
            Route::post('/create', [ArticleAdminController::class, 'createArticle'])->name('createArticle');
            Route::put('/update/{id}', [ArticleAdminController::class,'updateArticle'])
             ->name('article.update');
            Route::patch('/status/{id}', [ArticleAdminController::class, 'toggleStatus'])
             ->name('article.toggleStatus');
             Route::post('/{id}/feedback', [ArticleAdminController::class, 'storeFeedback'])->name('article.feedback.store');
            Route::delete('/photo/{id}',[ArticleAdminController::class,'deletePhoto'])
             ->name('article.photo.delete');
            Route::delete('/delete',[ArticleAdminController::class, 'deleteArticle'])->name('deleteArticle');
        });

        
        Route::prefix('kategori-article')->group(function() {
            Route::get('/', [ArticleKategoriAdminController::class, 'getKategoriArticle'])->name('getKategoriArticle');

            Route::get   ('/list',   [ArticleKategoriAdminController::class,'list']);
            Route::post  ('/create', [ArticleKategoriAdminController::class,'store']);
            Route::get   ('/show/{id}', [ArticleKategoriAdminController::class,'show']);
            Route::put   ('/update/{id}', [ArticleKategoriAdminController::class,'update']);
            Route::patch ('/status/{id}', [ArticleKategoriAdminController::class,'toggleStatus']);
            Route::delete('/delete/{id}',  [ArticleKategoriAdminController::class,'destroy']);
        });

        Route::prefix('komentar-articles')->group(function () {
            Route::get('/',            [ArticleKomentarAdminController::class,'index'])
                ->name('admin.commentArticle.index');
            Route::get('/list',        [ArticleKomentarAdminController::class,'list'])
                ->name('admin.commentArticle.list');
            Route::patch('/status/{id}', [ArticleKomentarAdminController::class,'toggleStatus'])
                ->name('admin.commentArticle.toggleStatus');
            Route::delete('/delete/{id}',[ArticleKomentarAdminController::class,'destroy'])
                ->name('admin.commentArticle.delete');
        });

       
    });

     Route::prefix('profil')->group(function () {
        Route::prefix('tentangkami')->group(function () {
            Route::get('/', [TentangKamiController::class, 'tentangkami'])->name('profil.tentangkami');
            Route::post('/create', [TentangKamiController::class, 'tentangkamiCreate'])->name('profil.tentangkamiCreate');
            Route::post('/edit/{id}', [TentangKamiController::class, 'tentangkamiEdit'])->name('profil.tentangkamiEdit');
            Route::post('/toggle-status/{id}', [TentangKamiController::class, 'toggleStatus'])->name('profil.tentangkamiToggleStatus');
            Route::delete('/delete/{id}', [TentangKamiController::class, 'tentangkamiDelete'])->name('profil.tentangkamiDelete');
        });

        Route::prefix('homekilau')->group(function () {
            Route::get('/', [HomeKilauController::class, 'homekilau'])->name('profil.homekilau');
            Route::post('/create', [HomeKilauController::class, 'homekilauCreate'])->name('profil.homekilauCreate');
            Route::post('/edit/{id}', [HomeKilauController::class, 'homekilauEdit'])->name('profil.homekilauEdit');
            Route::post('/toggle-status/{id}', [HomeKilauController::class, 'toggleStatus'])->name('profil.homekilauToggleStatus');
            Route::delete('/delete/{id}', [HomeKilauController::class, 'homekilauDelete'])->name('profil.homekilauDelete');
        });

        Route::prefix('iklankilau')->group(function () {
            Route::get('/', [IklanKilauController::class, 'iklankilau'])->name('profil.iklankilau');
            Route::post('/create', [IklanKilauController::class, 'iklankilauCreate'])->name('profil.iklankilauCreate');
            Route::post('/edit/{id}', [IklanKilauController::class, 'iklankilauEdit'])->name('profil.iklankilauEdit');
            Route::post('/toggle-status/{id}', [IklanKilauController::class, 'toggleStatus'])->name('profil.iklankilauToggleStatus');
            Route::delete('/delete/{id}', [IklanKilauController::class, 'iklankilauDelete'])->name('profil.iklankilauDelete');
        });
        
         Route::prefix('iklandonasi')->group(function () {
            Route::get('/', [IklanDonasiController::class, 'iklandonasi'])->name('profil.iklandonasi');
            Route::post('/create', [IklanDonasiController::class, 'iklandonasiCreate'])->name('profil.iklandonasiCreate');
            Route::post('/edit/{id}', [IklanDonasiController::class, 'iklandonasiEdit'])->name('profil.iklandonasiEdit');
            Route::post('/toggle-status/{id}', [IklanDonasiController::class, 'toggleStatus'])->name('profil.iklandonasiToggleStatus');
            Route::delete('/delete/{id}', [IklanDonasiController::class, 'iklandonasiDelete'])->name('profil.iklandonasiDelete');
        });

        Route::prefix('struktur')->group(function () {
            Route::get('/', [StrukturController::class, 'index'])->name('profil.struktur');
            Route::post('/create', [StrukturController::class, 'create'])->name('profil.strukturCreate');
            Route::post('/edit/{id}', [StrukturController::class, 'edit'])->name('profil.strukturEdit');
            Route::post('/toggle-status/{id}', [StrukturController::class, 'toggleStatus'])->name('profil.strukturToggleStatus');
            Route::delete('/delete/{id}', [StrukturController::class, 'delete'])->name('profil.strukturDelete');
        });

        Route::prefix('sejarah')->group(function () {
            Route::get('/', [SejarahController::class, 'index'])->name('profil.sejarah');
            Route::post('/create', [SejarahController::class, 'create'])->name('profil.sejarahCreate');
            Route::post('/edit/{id}', [SejarahController::class, 'edit'])->name('profil.sejarahEdit');
            Route::post('/toggle-status/{id}', [SejarahController::class, 'toggleStatus'])->name('profil.sejarahToggleStatus');
            Route::delete('/delete/{id}', [SejarahController::class, 'delete'])->name('profil.sejarahDelete');
        });

        Route::prefix('visimisi')->group(function () {
            Route::get('/', [VisiMisiController::class, 'index'])->name('profil.visimisi');
            Route::post('/create', [VisiMisiController::class, 'create'])->name('profil.visimisiCreate');
            Route::post('/edit/{id}', [VisiMisiController::class, 'edit'])->name('profil.visimisiEdit');
            Route::post('/toggle-status/{id}', [VisiMisiController::class, 'toggleStatus'])->name('profil.visimisiToggleStatus');
            Route::delete('/delete/{id}', [VisiMisiController::class, 'delete'])->name('profil.visimisiDelete');
        });

        Route::prefix('pimpinan')->group(function () {
            Route::get('/', [PimpinanController::class, 'index'])->name('profil.pimpinan');
            Route::post('/create', [PimpinanController::class, 'create'])->name('profil.pimpinanCreate');
            Route::post('/edit/{id}', [PimpinanController::class, 'edit'])->name('profil.pimpinanEdit');
            Route::post('/toggle-status/{id}', [PimpinanController::class, 'toggleStatus'])->name('profil.pimpinanToggleStatus');
            Route::delete('/delete/{id}', [PimpinanController::class, 'delete'])->name('profil.pimpinanDelete');
        });

        Route::prefix('legalitaslembaga')->group(function () {
            Route::get('/', [LegalitasLembagaController::class, 'index'])->name('profil.legalitaslembaga');
            Route::post('/create', [LegalitasLembagaController::class, 'store'])->name('profil.legalitaslembaga.create');
            Route::post('/edit/{id}', [LegalitasLembagaController::class, 'update'])->name('profil.legalitaslembaga.edit');
            Route::post('/toggle-status/{id}', [LegalitasLembagaController::class, 'toggleStatus'])->name('profil.legalitaslembaga.toggleStatus');
            Route::delete('/delete/{id}', [LegalitasLembagaController::class, 'destroy'])->name('profil.legalitaslembaga.delete');
        });

    });  
    
    Route::prefix('hubungi-kami')->group(function() {
        Route::prefix('colaborasi')->group(function () {
            Route::get('/', [ColaborasiController::class, 'colaborasi'])->name('colaborasi');
            Route::get('/show/{id}', [ColaborasiController::class, 'colaborasiShow'])->name('colaborasi.show');
            Route::post('/kirimjawaban/{id}', [ColaborasiController::class, 'update'])->name('colaborasi.update');
            Route::post('/toggle-status/{id}', [ColaborasiController::class, 'toggleStatus'])->name('colaborasi.toggleStatus');
            Route::delete('/delete/{id}', [ColaborasiController::class, 'destroy'])->name('colaborasi.delete');
        });
    
        Route::prefix('kontak')->group(function () {
            Route::get('/', [KontakController::class, 'index'])->name('kontak');
            Route::post('/create', [KontakController::class, 'store'])->name('kontak.create');
            Route::post('/edit/{id}', [KontakController::class, 'update'])->name('kontak.edit');
            Route::post('/toggle-status/{id}', [KontakController::class, 'toggleStatus'])->name('kontak.toggleStatus');
            Route::delete('/delete/{id}', [KontakController::class, 'destroy'])->name('kontak.delete');
        });
    });

    Route::prefix('berita-kilau')->group(function(){
        Route::prefix('berita')->group(function () {
            Route::get('/', [BeritaAdminController::class, 'index'])->name('berita');
        });

        Route::prefix('kategori')->group(function() {
            Route::get('/', [BeritaAdminController::class, 'getKategoriBerita'])->name('getKategoriBerita');
        });

        Route::prefix('komentar')->group(function() {
            Route::get('/', [BeritaAdminController::class, 'getKomentarBerita'])->name('getKomentarBerita');
        });
    });

    Route::prefix('program-kilau')->group(function(){
        // Program Routes
        Route::prefix('program')->group(function () {
            Route::get('/', [ProgramController::class, 'index'])->name('program');
            Route::post('/create', [ProgramController::class, 'store'])->name('program.create');
            Route::post('/edit/{id}', [ProgramController::class, 'update'])->name('program.edit');
            Route::post('/toggle-status/{id}', [ProgramController::class, 'toggleStatus'])->name('program.toggleStatus');
            Route::delete('/delete/{id}', [ProgramController::class, 'destroy'])->name('program.delete');
        });

         Route::prefix('program-referrals')->group(function () {
            Route::get('/', [ProgramReferallController::class, 'index'])->name('programReferrals');
            Route::get('/show/{id}', [ProgramReferallController::class, 'show']);
            Route::patch('/approve/{id}', [ProgramReferallController::class, 'approve'])->name('programReferrals.approve');
            Route::patch('/reject/{id}', [ProgramReferallController::class, 'reject'])->name('programReferrals.reject');
            // Route::delete('/delete/{id}', [ProgramController::class, 'destroy'])->name('program.delete');
        });
    });

    // Testimoni Routes
    Route::prefix('testimoni')->group(function () {
        Route::get('/', [TestimoniController::class, 'testimoni'])->name('testimoni');
        Route::post('/create', [TestimoniController::class, 'testimoniCreate'])->name('testimoniCreate');
        Route::post('/edit/{id}', [TestimoniController::class, 'testimoniEdit'])->name('testimoniEdit');
        Route::post('/toggle-status/{id}', [TestimoniController::class, 'toggleStatus'])->name('testimoniToggleStatus');
        Route::delete('/delete/{id}', [TestimoniController::class, 'testimoniDelete'])->name('testimoniDelete');
    });

    Route::prefix('galeryAdmin')->group(function () {
        Route::get('/', [GaleriAdminController::class, 'index'])->name('galeryAdmin');
        Route::post('/create', [GaleriAdminController::class, 'store'])->name('galeryAdmin.create');
        Route::post('/edit/{id}', [GaleriAdminController::class, 'update'])->name('galeryAdmin.edit');
        Route::post('/toggle-status/{id}', [GaleriAdminController::class, 'toggleStatus'])->name('galeryAdmin.toggleStatus');
        Route::delete('/delete/{id}', [GaleriAdminController::class, 'destroy'])->name('galeryAdmin.delete');
    });

    // FAQ Routes
    Route::prefix('faq')->group(function () {
        Route::get('/', [FaqController::class, 'index'])->name('faq');
        Route::post('/create', [FaqController::class, 'store'])->name('faq.create');
        Route::post('/edit/{id}', [FaqController::class, 'update'])->name('faq.edit');
        Route::post('/toggle-status/{id}', [FaqController::class, 'toggleStatus'])->name('faq.toggleStatus');
        Route::delete('/delete/{id}', [FaqController::class, 'destroy'])->name('faq.delete');
    });

    // Mitra Routes
    Route::prefix('mitra')->group(function () {
        Route::get('/', [MitraDonaturController::class, 'index'])->name('mitra');
        Route::post('/create', [MitraDonaturController::class, 'store'])->name('mitra.create');
        Route::post('/edit/{id}', [MitraDonaturController::class, 'update'])->name('mitra.edit');
        Route::post('/toggle-status/{id}', [MitraDonaturController::class, 'toggleStatus'])->name('mitra.toggleStatus');
        Route::delete('/delete/{id}', [MitraDonaturController::class, 'destroy'])->name('mitra.delete');
    });

    // Kontak Routes
    // Route::prefix('kontak')->group(function () {
    //     Route::get('/', [KontakController::class, 'index'])->name('kontak');
    //     Route::post('/create', [KontakController::class, 'store'])->name('kontak.create');
    //     Route::post('/edit/{id}', [KontakController::class, 'update'])->name('kontak.edit');
    //     Route::post('/toggle-status/{id}', [KontakController::class, 'toggleStatus'])->name('kontak.toggleStatus');
    //     Route::delete('/delete/{id}', [KontakController::class, 'destroy'])->name('kontak.delete');
    // });

    Route::prefix('document')->group(function () {
        Route::get('/', [DokumenAdminController::class, 'index'])->name('document');
        Route::post('/create', [DokumenAdminController::class, 'store'])->name('document.create');
        Route::post('/edit/{id}', [DokumenAdminController::class, 'update'])->name('document.edit');
        Route::post('/toggle-status/{id}', [DokumenAdminController::class, 'toggleStatus'])->name('document.toggleStatus');
        Route::delete('/delete/{id}', [DokumenAdminController::class, 'destroy'])->name('document.delete');
    });

    Route::prefix('timeline')->group(function () {
        Route::get('/', [TimelineController::class, 'index'])->name('timeline');
        Route::post('/create', [TimelineController::class, 'store'])->name('timeline.create');
        Route::post('/edit/{id}', [TimelineController::class, 'update'])->name('timeline.edit');
        Route::post('/toggle-status/{id}', [TimelineController::class, 'toggleStatus'])->name('timeline.toggleStatus');
        Route::delete('/delete/{id}', [TimelineController::class, 'destroy'])->name('timeline.delete');
    });

    // Settings Menu Routes
    Route::prefix('settingsmenu')->group(function () {
        Route::get('/', [SettingsMenuController::class, 'index'])->name('settingsmenu');
        Route::post('/create', [SettingsMenuController::class, 'store'])->name('settingsmenu.create');
        Route::post('/edit/{id}', [SettingsMenuController::class, 'update'])->name('settingsmenu.edit');
        Route::post('/toggle-status/{id}', [SettingsMenuController::class, 'toggleStatus'])->name('settingsmenu.toggleStatus');
        Route::delete('/delete/{id}', [SettingsMenuController::class, 'destroy'])->name('settingsmenu.delete');
    });

});