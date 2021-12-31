<x-app-layout>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Black+Han+Sans&display=swap" rel="stylesheet">
    <div class="py-12" style=" background: linear-gradient(#5D76F7 30%, #fff 10%)">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <p style="text-align:center;font-family: 'Black Han Sans', sans-serif; font-size: 50px">맛집 등록</p>
                <form action="/insert" method="post">
                        @csrf
                    <table border="1" style="margin: 0 auto">
                        <tr>
                            <th>식당명</th>
                            <td>@include('layouts.input', [
                                'field'  => 'name'
                            ])</td>
                        </tr>
                        <tr>
                            <th>식당 대표메뉴</th>
                            <td>@include('layouts.input', [
                                'field'  => 'menu'
                            ])</td>
                        </tr>
                        <tr>
                            <th>음식 카테고리</th>
                            <td><select name="category">
                                    <option value="All">전체</option>    
                                    <option value="Chinese">중식</option>
                                    <option value="Japanese">일식</option>
                                    <option value="Korean">한식</option>
                                    <option value="American">양식</option>
                                    <option value="night">술집</option>
                            </select></td>
                        </tr>
                        <tr>
                            <th>좌표</th>
                            <td><input type="text" value="37.481786,126.884950" name="location" id="location" readonly></td>
                        </tr>
                        <tr>
                            <div id="map" style="width:500px;height:350px; margin: 0 auto"></div>
                            <p style="text-align: center">맛집 위치를 클릭해주세요</p> 
                        </tr>
                        <tr>
                            <th>해시태그</th>
                            <td><div class="tr_hashTag_area">
                                <p><strong>해시태그 구현</strong></p>
                                       <div class="form-group">
                                            <input type="hidden" value="" name="tag" id="rdTag" />
                                        </div>
                                    
                                         <ul id="tag-list" name="tag-list"></ul>
                                                    
                                        <div class="form-group">
                                            <input type="text" id="tag" size="7" placeholder="엔터로 해시태그를 등록해주세요." style="width: 300px;"/>
                                       </div>
                            </div></td>
                        </tr>
                        <tr>
                            <td colspan="2">@include('layouts.input', [
                                'type'  => 'submit',
                                'value' => '등록'
                            ])</td>
                        </tr>
                    </table>
                </form>
            </div>
        </div>
    {{--  <div id="clickLatlng" style="text-align: center"></div>  --}}
    
    <script type="text/javascript" src="//dapi.kakao.com/v2/maps/sdk.js?appkey=5a3903418989f73a7ab64c6181d8de3c"></script>
    <script  src="http://code.jquery.com/jquery-latest.min.js"></script>
    <script>
         $(document).ready(function () {
        var tag = {};
        var counter = 0;

        // 입력한 값을 태그로 생성한다.
        function addTag (value) {
            tag[counter] = value;
            counter++; // del-btn 의 고유 id 가 된다.
        }

        // tag 안에 있는 값을 array type 으로 만들어서 넘긴다.
        function marginTag () {
            return Object.values(tag).filter(function (word) {
                return word !== "";
            });
        }
    
        // 서버에 제공
        $("#tag-2").on("submit", function (e) {
            var value = marginTag(); // return array
            $("#rdTag").val(value); 

            $(this).submit();
        });

        $("#tag").on("keypress", function (e) {
            var self = $(this);

            //엔터나 스페이스바 눌렀을때 실행
            if (e.key === "Enter" || e.keyCode == 32) {

                var tagValue = "#" + self.val(); // 값 가져오기

                // 해시태그 값 없으면 실행X
                if (tagValue !== "") {

                    // 같은 태그가 있는지 검사한다. 있다면 해당값이 array 로 return 된다.
                    var result = Object.values(tag).filter(function (word) {
                        return word === tagValue;
                    })
                
                    // 해시태그가 중복되었는지 확인
                    if (result.length == 0) { 
                        $("#tag-list").append("<li class='tag-item'>"+tagValue+"<span class='del-btn' idx='"+counter+"'>x</span></li>");
                        // $("#tag").attr("<li class='tag-item'>"+tagValue+"<span class='del-btn' idx='"+counter+"'>x</span></li>");
                        addTag(tagValue);
                        self.val("");
                    } else {
                        alert("태그값이 중복됩니다.");
                    }
                }
                e.preventDefault(); // SpaceBar 시 빈공간이 생기지 않도록 방지
            }
        });

        // 삭제 버튼 
        // 인덱스 검사 후 삭제
        $(document).on("click", ".del-btn", function (e) {
            var index = $(this).attr("idx");
            tag[index] = "";
            $(this).parent().remove();
        });
})
    var mapContainer = document.getElementById('map'), // 지도를 표시할 div 
        mapOption = { 
            center: new kakao.maps.LatLng(37.481786, 126.884950), // 지도의 중심좌표
            level: 3 // 지도의 확대 레벨
        };
    
    var map = new kakao.maps.Map(mapContainer, mapOption); // 지도를 생성합니다
    
    // 지도를 클릭한 위치에 표출할 마커입니다
    var marker = new kakao.maps.Marker({ 
        // 지도 중심좌표에 마커를 생성합니다 
        position: map.getCenter() 
    }); 
    // 지도에 마커를 표시합니다
    marker.setMap(map);
    
    // 지도에 클릭 이벤트를 등록합니다
    // 지도를 클릭하면 마지막 파라미터로 넘어온 함수를 호출합니다
    kakao.maps.event.addListener(map, 'click', function(mouseEvent) {        
        
        // 클릭한 위도, 경도 정보를 가져옵니다 
        var latlng = mouseEvent.latLng; 
        
        // 마커 위치를 클릭한 위치로 옮깁니다
        marker.setPosition(latlng);
        
        var resultDiv = document.getElementById('clickLatlng'); 
    
        document.getElementById("location").value = latlng.getLat() + "," + latlng.getLng()
        
    });
    
    </script>
    </div>
</x-app-layout>