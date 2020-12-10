- composer require livewire/livewire
- include di head dan body
	# @livewireStyles
	# @livewireScripts
- membuat component get data
	# php artisan livewire:make ContactIndex (untuk proses get data)
- terdapat file 
	# ContactIndex.php (see file)
	# contact-index.blade.php (see file)
- untuk memanggil komponen
	# <livewire:contact-index></livewire:contact-index>

#######proses create data #############
- membuat component create
	# php artisan livewire:make ContactCreate (untuk proses create)
- untuk mengirimkan/ parsing data gunakan 
	<livewire:contact-create :contacts="$contacts"></livewire:contact-create> (props)
	# perhatikan file contact-index.blade.php
	# contactcreate.php
