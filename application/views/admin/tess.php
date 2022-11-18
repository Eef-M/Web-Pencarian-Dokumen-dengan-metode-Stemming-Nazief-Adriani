<!-- <?php
	$this->load->database();
	$keyword = "";	
	$queryCondition = "";
	if(!empty($_POST["keyword"])) {
		$keyword = $_POST["keyword"];
		$wordsAry = explode(" ", $keyword);
		$wordsCount = count($wordsAry);
		$queryCondition = " WHERE ";
		for($i=0;$i<$wordsCount;$i++) {
			$queryCondition .= "nama_file LIKE '%" . $wordsAry[$i] . "%' OR desk LIKE '%" . $wordsAry[$i] . "%'";
			if($i!=$wordsCount-1) {
				$queryCondition .= " OR ";
			}
		}
	}
	$orderby = " ORDER BY id_text desc"; 
	$sql = "SELECT * FROM `text` " . $queryCondition;
    return $this->db->query($sql)->result();
?> -->
<!-- <?php 
	function highlightKeywords($text, $keyword) {
		$wordsAry = explode(" ", $keyword);
		$wordsCount = count($wordsAry);

		for($i=0;$i<$wordsCount;$i++) {
			$highlighted_text = "<span style='background-color:yellow ; color:black;'><strong>$wordsAry[$i]</strong></span>";
			$text = str_ireplace($wordsAry[$i], $highlighted_text, $text);
		}

		return $text;
	}
?> -->
<div class="card text-center mx-4">
    <div class="card-body">
        <div class="row align-items-center justify-content-center">
            <div class="col-md-9">
                <form action="<?= base_url('user/search') ?>" method="post" enctype="multipart/form-data">
                    <div class="input-group form-container">
                        <input required type="text" name="keyword" class="form-control border border-primary"
                            placeholder="Cari Dokumen ..." autocomplete="off" autofocus>
                        <button style="background-color: #2155CD;" type="submit" class="btn text-white">Cari</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?php if(empty($cari)) : ?>
<div class="card mx-4 my-3 bg-100" id="Thecard">
    <!-- <a href="#" class="btn" id="cdbtn"> -->
    <div class="card-body text-center my-4">
        <h2 class="card-title text-danger"><strong>Data tidak ditemukan!</strong></h2>
    </div>
    <!-- </a> -->
</div>
<?php else : ?>
<div class="card mx-6 my-3">
    <!-- <a href="<?= base_url('user/search/detail/'. $cr['id']) ?>" class="btn" id="cdbtn"> -->
    <div class="card-body text-start">
        <table class="table table-borderless">
            <thead>
                <tr class="text-center text-dark bg-200">
                    <!-- <th scope="col">No</th> -->
                    <!-- <th scope="col">Nama File</th>
                    <th scope="col">ID</th>
                    <th scope="col">Token</th>
                    <th scope="col">Token Stemming</th> -->
                </tr>
            </thead>
            <?php $no = 1; ?>
            <?php foreach($cari as $cr) : ?>
            <!-- <tbody>
                <tr class="text-start">
                    <td>Nama File : <strong class="text-1000"><?= $cr['nama_file'] ?></strong>
                    </td>
                    <td>ID : <strong class="text-900"><?= $cr['dokid'] ?></strong>
                    </td>
                    <td>Token : <strong class="fw-bold fst-italic text-info"><?= $cr['token'] ?></strong>
                    </td>
                    <td>Token Stemming : <strong class="fw-bold fst-italic text-danger"><?= $cr['tokenstem'] ?></strong>
                    </td>
                </tr>
            </tbody> -->
            <tbody>
                <tr class="text-start">
                    <!-- <th scope="row"><?= $no++ ?></th> -->
                    <td>Nama File : <strong class="text-1000"><?= $cr['nama_file'] ?></strong>
                    </td>
                    <td>ID : <strong class="text-900"><?= $cr['dokid'] ?></strong>
                    </td>
                    <td>Token : <strong class="fw-bold fst-italic text-info"><?= $cr['token'] ?></strong>
                    </td>
                    <td>Token Stemming : <strong class="fw-bold fst-italic text-danger"><?= $cr['tokenstem'] ?></strong>
                    </td>
                </tr>
            </tbody>
            <?php endforeach ?>
        </table>
    </div>
    <!-- </a> -->
</div>
<?php endif ?>


<div>
    <div class="card my-4"></div>
</div>