Analisis Tugas 3 - Inventory Service (Service A)

Nama: Ahmad Rizky Ivanzya  
NIM: 102022400004  

Penjelasan Transaksi/Endpoint Kritis 

Transaksi/endpoint yang saya pilih paling kritis/penting yaitu karena endpoint penerimaan komponen (POST /api/v1/components-receive) merupakan satu-satunya endpoint pada inventory punya saya (inventory service) yang melakukan perubahan stok data di database. Endpoint ini juga menerapkan skema role lokal dimana hak aksesnya dibatasi khusus untuk akun dengan role Admin Gudang.Tanpa endpoint ini data stok tidak akan diperbarui meskipun barang sudah tiba di gudang sehingga tim produksi tidak dapat mengetahui ketersediaan bahan baku secara akurat. Endpoint ini juga menjadi titik akhir dari seluruh alur proses bisnis Inbound Supply Chain, di mana proses pengadaan dari Service B dan pelacakan logistik dari Service C baru dinyatakan selesai setelah penerimaan barang tercatat di sistem. Karena transaksi ini mengubah jumlah barang yang berhubungan langsung dengan pengeluaran, setiap prpsesnya harus dicatat dalam audit menggunakan SOAP untuk mengirinkan data hasil audit stok ini secara aman ke sistem pabrik karena menyangkut data barang yang penting untuk perusahaan. Selain itu, data barang masuk ini juga langsung dibagikan ke service lain menggunakan RabbitMQ, supaya status PO di Service B dan status kendaraan pengantar di Service C bisa otomatis berubah jadi selesai tanpa membuat saling menunggu.

Detail mengenai alur interaksi untuk endpoint ini dapat dilihat pada diagram sequence yang terdapat di folder service dengan nama file Sequence IAE.png 