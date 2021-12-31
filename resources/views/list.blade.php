<script  type="text/javascript" src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <script>
        function kakaoImg($menu) {
            $.ajax({
                type:"POST",
                url: "https://dapi.kakao.com/v2/search/image",
                headers : {
                    'Authorization': 'KakaoAK d185f11460bc251aa8c99235d6ab0886'
                },
                data: {
                    'query' : $menu,
                    'sort' : 'accuracy',
                    'size' : 1
                },
                success:function(jdata) {
                    console.log($menu);
                    
                    $(jdata.documents).each(function(index){
                        $("div#content").append('<img src="'+this.image_url+'" style="width:100px"/>');
                    });
                },
                error:function(xhr,textStatus) {
                    $("div#content").append('<p>실패</p>');
                    return;
                }
            });
        }
</script>
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            <a href="/dashboard/All" style="margin-right: 20px">전체</a>
            <a href="/dashboard/Chinese" style="margin-right: 20px">중식</a>
            <a href="/dashboard/Japanese" style="margin-right: 20px">일식</a>
            <a href="/dashboard/Korean" style="margin-right: 20px">한식</a>
            <a href="/dashboard/American" style="margin-right: 20px">양식</a>
            <a href="/dashboard/night" style="margin-right: 20px">술집</a>
        </h2>
        <div class="gcse-search"></div>
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <h2 style="font-weight: bold; font-size: 30px; text-align: center; margin: 20px">{{ $type }}</h2>
                @foreach($lists as $list)
                    <div style=" margin: 30px; display: flex; -moz-border-radius:10px; -webkit-border-radius:10px; border-radius:20px; box-shadow:3px 3px 3px 3px #999;" id="content">
                        <ul style="display: flex">
                            <div>
                                <li><img src="https://source.unsplash.com/featured/?<?= $list->r_category ?>" style="width: 130px; height: 130px; margin: 10px; border-radius: 50%;"></li>
                            </div>
                            <div style="align-items: center">
                                <li style="margin: 20px">음식점 이름 : <a href="https://map.kakao.com/link/to/{{ $list->r_name }},{{ $list->r_location }}">{{ $list->r_name }}</a></li>
                                <li style="margin: 20px">대표 메뉴 : {{ $list->r_menu }}</li>
                                <li style="margin: 20px">해시태그 : {{ $list->r_tag }}</li>
                            </div>
                        </ul>
                    </div>
                @endforeach
                
            </div>
        </div>
    </div>
</x-app-layout>