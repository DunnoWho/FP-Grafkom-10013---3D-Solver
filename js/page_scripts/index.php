<script>
    loadPageContent([
        makePageContent("panel_content", "fa-graduation-cap", "Selamat datang di program 3D solver!", "Tekan tombol lanjut untuk memulai", []),
        makePageContent("panel_content", "fa-list-alt", "List contoh soal jarak", "", [
            "Jarak 2 titik",
            "<ul><li><a target='_blank' href='/jtt.php?in1=H&in2=C&shape=0&l=1&w=1&h=1'>Kubus</a></li><li><a target='_blank' href='/jtt.php?in1=A&in2=Z&shape=0&l=10&w=8&h=6'>Balok</a></li><li><a target='_blank' href='/jtt.php?in1=D&in2=J&shape=1&l=8&w=8&h=6'>Limas segiempat</a></li></ul>",
            "Jarak titik ke garis",
            "<ul><li><a target='_blank' href='/jtg.php?in1=A&in2=CG&shape=0&l=1&w=1&h=1'>Kubus 1</a></li><li><a target='_blank' href='/jtg.php?in1=A&in2=BH&shape=0&l=1&w=1&h=1'>Kubus 2</a></li><li><a target='_blank' href='/jtg.php?in1=B&in2=EG&shape=0&l=10&w=8&h=6'>Balok</a></li><li><a target='_blank' href='/jtg.php?in1=T&in2=AB&shape=1&l=8&w=8&h=6'>Limas segiempat</a></li></ul>",
            "Jarak titik ke bidang",
            "<ul><li><a target='_blank' href='/jtb.php?in1=E&in2=BDG&shape=0&l=1&w=1&h=1'>Kubus</a></li><li><a target='_blank' href='/jtb.php?in1=M&in2=GNP&shape=0&l=6&w=6&h=12'>Balok</a></li><li><a target='_blank' href='/jtb.php?in1=H&in2=BCT&shape=1&l=8&w=8&h=6'>Limas segiempat</a></li></ul>",
        ]),
        makePageContent("panel_content", "fa-list-alt", "List contoh soal sudut", "", [
            "Sudut antara 2 garis",
            "<ul><li><a target='_blank' href='/sgg.php?in1=AS&in2=CS&shape=0&l=1&w=1&h=1'>Kubus 1</a></li><li><a target='_blank' href='/sgg.php?in1=AF&in2=CH&shape=0&l=1&w=1&h=1'>Kubus 2</a></li><li><a target='_blank' href='/sgg.php?in1=AF&in2=GD&shape=0&l=1&w=1&h=1'>Kubus 3</a></li><li><a target='_blank' href='/sgg.php?in1=AH&in2=TJ&shape=0&l=1&w=1&h=1'>Kubus 4</a></li><li><a target='_blank' href='/sgg.php?in1=AH&in2=AG&shape=0&l=1&w=1&h=1'>Kubus 5</a></li><li><a target='_blank' href='/sgg.php?in1=AR&in2=FT&shape=0&l=6&w=12&h=6'>Balok</a></li><li><a target='_blank' href='/sgg.php?in1=DJ&in2=BC&shape=1&l=8&w=8&h=6'>Limas segiempat</a></li></ul>",
        ]),
        makePageContent("form", "fa-pencil-ruler", "Form input soal", "", []),
    ]);
</script>