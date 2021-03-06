

<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" type="text/css" href="css\bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="css\stylelucky.css">

    <title>Belajar Bootstratp
    </title>
  </head>


  <body>  
    <!-- INI NAV BAR NYA -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
      <a class="navbar-brand" href="#">
        <img src="img/icon1.png" widht="30" height="30" alt="Dashboard">
        
      </a>
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
    
      <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav mr-auto">
          <li class="nav-item active">
            <a class="nav-link" href="#">Home <span class="sr-only">(current)</span></a>
          </li>
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
              Agen
            </a>
            <div class="dropdown-menu" aria-labelledby="navbarDropdown">
              <a class="dropdown-item" href="#">Laporan Agen</a>
              <div class="dropdown-divider"></div>
              <a class="dropdown-item" href="#">EDC</a>
              <div class="dropdown-divider"></div>
              <a class="dropdown-item" href="#">BPNT</a>
            </div>
          </li>
        </ul>
        <form class="form-inline my-2 my-lg-0">
          <input class="form-control mr-sm-2" type="search" placeholder="Search" aria-label="Search">
          <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
        </form>
      </div>
    </nav>
    <!-- AKHIR DARI NAV BAR -->

    <?php
      // SETTING KONEKSI KE DATABASE DAN PAGGING
      include 'config.php';
      $batas = 10; // variabel Jumlah Maksimum Perhalaman
      $halaman = @$_GET['halaman']; // penentuan halaman dan posisi paging
      if (empty($halaman)){
        $posisi = 0;
        $halaman = 1;
      }
      else{
        $halaman++;
        $posisi = ($halaman-1) * $batas;
      }

      $data = mysqli_query($koneksi,"select*from agen ORDER BY kode_agen ASC LIMIT $posisi,$batas");

      $datacount = mysqli_query($koneksi,"select count(nama_agen) from agen");
      $count = mysqli_fetch_row($datacount);
      $jmlhalaman = ceil($count[0] / $batas);
      $set = $jmlhalaman-($jmlhalaman-$halaman);


      // cek jika koneksi error karena apa
      if (!$data) {
      printf("Error: %s\n", mysqli_error($koneksi));
      exit();
      }
    ?>


  <div class="container-fluid text-center" >
      <h3>Data Agen BNI KC Garut</h3>
      </hr>
      <h5>Total <?php echo $count[0];?> Agen</h5>
      <h6><?php echo $set;?></h6>
    </br>
    </div>

    <!-- Tabel Data Agen   -->
  
  <div class="container">
  <div class="row">    
    <div class="col">    
    <table class="table table-striped table-responsive">
      <thead>
        <tr>
          <th scope="col">No</th>
          <th scope="col">Kode Agen</th>
          <th scope="col">Nama Agen</th>
        </tr>
      </thead>
      <tbody>
      <!-- Mulai SCRIPT PHP -->
    <?php
    $no = $posisi+1;
     while($d = mysqli_fetch_array($data)){
    ?>
      <tr>
          <th><?php echo $no; ?></th>
          <td>
          <!-- narik data kode agen untuk di jadikan ID dengan method GET -->
            <a href="detailagen.php?id=<?php echo $d['kode_agen']; ?>"><?php echo $d['kode_agen']; ?></a>
          </td>
          <td><?php echo $d['nama_agen']; ?></td>
        </tr>
        
      <?php
      $no++;
      }

      // hitung pagging nya
      ?>      
      </tbody>
    </table>
    <!-- NGATUR PAGING NYA -->


    <div class="container">
       <nav aria-label="Page navigation example offset-sm-2">
        <ul class="pagination pagination-sm">
          <?php
          if ($set>=$jmlhalaman+1){
            $akhirpage = $set
          ?>
          
          <li class="page-item"><a class="page-link" href="index.php?halaman=<?php echo $akhirpage--; ?>">
              Pervious
            </a>
          </li>          
          <li class="page-item disabled"><a class="page-link" href="#">Next</a></li>


          <?php
          }
          else {

          ?>
          <li class="page-item ">
            <a class="page-link" href="index.php?halaman=<?php echo $set; ?>">
              Pervious
            </a>
          </li>
          <li class="page-item">
            <a class="page-link" href="index.php?halaman=<?php echo $set++; ?>">
              Next
            </a>           
          </li> 
          <?php
          }      
          ?>    
      </ul>
    </nav>
  </div>

     
  
    </div>

      <div class="col">
        <div class = "container text-center">
        <h4>REPORTS</h4>
      <?php
      $databpnt = mysqli_query($koneksi,"select count(bpnt) from agen where bpnt='1'");
      $dataedc = mysqli_query($koneksi,"select count(edc) from agen where edc='1'");
      $countbpnt = mysqli_fetch_row($databpnt);
      $countedc = mysqli_fetch_row($dataedc);
      
      // cek jika koneksi error karena apa
      if (!$databpnt) {
      printf("Error: %s\n", mysqli_error($koneksi));
      exit();
      }
      ?>
      <table class="table table-striped table-responsive">
      <thead>
        <tr>
          <th scope="col">Jumlah</th>
          <th scope="col">Keterangan</th>
        </tr>
      </thead>
      <tbody>
        <th>
          <a href="#"> <?php echo $countbpnt[0];?> </a>
        </th>
        <td>
          Jumlah Agen yang Aktif BPNT
        </td>
        </tr>
        <th>  
          <a href="#"> <?php echo $countedc[0];?> </a>
        </th>

        <td>
          Jumlah Agen yang Memiliki EDC 
        </td>

      </tbody>
      </table>
      </div>
    </div>
  </div>
</div>
    <!-- Akhir Tabel Data Agen -->
    <!-- Optional JavaScript -->    
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
  </body>





</html>