@extends('layouts.default')


@section('content')

    <!-- Start Content-->
    <div class="container-fluid">

        <div class="row">
            <div class="col-sm-8">
                <div class="bg-picture card-box">
                    <div class="profile-info-name">
                        <img src="/images/users/{{Auth::user()->avatar}}"
                                class="rounded-circle avatar-xl img-thumbnail float-left mr-3" alt="profile-image">

                        <div class="profile-info-detail overflow-hidden">
                            <h4 class="m-0">{{Auth::user()->name}}</h4>
                            <p class="text-muted"><i>{{Auth::user()->getRoleNames()[0]}}</i></p>
                            <p class="font-16">{{ Auth::user()->email}}</p>

                            <ul class="social-list list-inline mt-3 mb-0">
                                <li class="list-inline-item">
                                    <a href="javascript: void(0);" class="social-list-item border-purple text-purple"><i
                                            class="mdi mdi-facebook"></i></a>
                                </li>
                                <li class="list-inline-item">
                                    <a href="javascript: void(0);" class="social-list-item border-danger text-danger"><i
                                            class="mdi mdi-google"></i></a>
                                </li>
                                <li class="list-inline-item">
                                    <a href="javascript: void(0);" class="social-list-item border-info text-info"><i
                                            class="mdi mdi-twitter"></i></a>
                                </li>
                                <li class="list-inline-item">
                                    <a href="javascript: void(0);" class="social-list-item border-secondary text-secondary"><i
                                            class="mdi mdi-github"></i></a>
                                </li>
                            </ul>

                            <form enctype="multipart/form-data" action="/profile" method="post">
                                @csrf
                                <input type="file" class="far fa-image" name="avatar" >
                                <input type="submit" class="btn btn-primary">
                            </form>
                        </div>

                        <div class="clearfix"></div>
                    </div>
                </div>
                <!--/ meta -->

                <div class="card-box">
                    <pre>
1. Các bước chuẩn bị để giới thiệu bản thân ấn tượng
    Xác định các kỹ năng quan trọng nhất mà nhà tuyển dụng đang tìm kiếm và kết hợp chúng vào phần giới thiệu. Điều này sẽ ngay lập tức cho nhà tuyển dụng thấy bạn là người phù hợp với công việc.

    Hãy suy nghĩ về những gì họ có thể muốn nghe. Suy nghĩ về những gì nhà tuyển dụng tiềm năng muốn nghe cũng sẽ giúp bạn quyết định sẽ bỏ đi hoặc thêm vào nội dung gì trong phần giới thiệu.

    Hãy tự hỏi mình một số câu hỏi. Trả lời những câu hỏi như Bạn là ai? Tại sao bạn lại muốn làm việc cho công ty này? Những kỹ năng và kinh nghiệm chuyên môn khiến bạn đủ điều kiện để làm việc ở đây? Bạn hy vọng đạt được điều gì trong sự nghiệp? và sử dụng chúng để tạo ra phần giới thiệu của bạn.

    Viết ra và chỉnh sửa. Viết phần giới thiệu của bạn ra giấy bắt đầu bằng các chi tiết cơ bản về bản thân (bạn là ai?), sau đó chuyển sang kỹ năng và kinh nghiệm chuyên môn và kết thúc bằng các mục tiêu nghề nghiệp chính. Bên cạnh đó, hãy nhớ rút ngắn lời giới thiệu bởi nhà tuyển dụng chỉ muốn có một cái nhìn tổng quan nhanh về con người bạn.

    Tập luyện. Hãy tập luyện phần giới thiệu của bạn cho đến khi nghe có vẻ tự nhiên như đang trò chuyện. Để nhớ các ý chính, bạn có thể viết chúng trong một cuốn sổ tay và đem theo bên mình. Trong cuộc phỏng vấn, nó sẽ giúp bạn an tâm hơn vì bạn có thể liếc nhìn nếu cảm thấy lo lắng.

2. Nên nói những gì khi giới thiệu bản thân?
    Hãy nói về một vài những điểm chính của bản thân

    Khi bắt đầu cuộc phỏng vấn, bạn hãy chú ý và đưa ra một vài điểm chính về bản thân thật thú vị và hữu ích cho sự tiếp diễn liên tục của buổi phỏng vấn.

    Trong hai hoặc ba câu bạn hãy tập trung vào phần gây hứng thú nhất cho người phỏng vấn – bắt đầu với công việc gần đây nhất của bạn, giải thích tại sao bạn lại hứng thú với vị trí này và tại sao bạn là ứng viên thực sự phù hợp cho vị trí đó – dựa trên bằng cấp, kinh nghiệm cũng như kỹ năng của bạn.

    Nhấn mạnh những thành tựu nổi bật nhất của bản thân – thêm một vài câu chuyện ngắn có liên quan để hướng sự chú ý của người phỏng vấn tới những thành quả của bạn.

    Trả lời câu hỏi một cách ngắn gọn, súc tích

    Trong khi giới thiệu về bản thân, hãy cố gắng nói thật rõ ràng và chính xác những thông tin về mình. Sự giới thiệu dài dòng và quanh co có thể làm mất sự hứng thú của người phỏng vấn ngay từ thời điểm bắt đầu – cách tốt nhất để giới thiệu về bản thân một người trong cuộc phỏng vấn là chuẩn bị một bản tóm tắt về nội dung, một bản profile bằng văn nói thật dễ nhớ. Do vậy người đó có thể nói một cách trôi chảy, tự tin và tất nhiên sẽ tạo được ấn tượng tốt cho người phỏng vấn.

    Đừng bao giờ kéo dài thời gian, hãy tính toán sao cho câu trả lời của bạn kéo dài tối đa là 1 phút. Bạn sẽ muốn tương tác với người phỏng vấn sớm nhất có thể, hãy trao cho họ cơ hội dẫn dắt cuộc hội thoại tốt hơn là bỏ qua bạn ngay từ lúc bắt đầu cuộc hội thoại.

    Đừng nhắc lại những từ, cụm từ có trong CV của bạn

    Hãy nhớ rằng CV của bạn đã nằm ở trên bàn và trước mặt người phỏng vấn rồi. Tất nhiên, bạn có thể bổ sung thêm thông tin trong quá trình phỏng vấn.

    Khi hỏi câu hỏi này, người phỏng vấn muốn lắng nghe một bài giới thiệu ngắn gọn, súc tích và rõ ràng về những điểm chính về bản thân bạn.

    Khi bạn bắt đầu giới thiệu về bản thân, cũng là lúc nhà tuyển dụng chuẩn bị cho các câu hỏi tiếp dựa trên phần trả lời của bạn. Bởi vậy, chuẩn bị cho một câu trả lời thông minh sẽ là giải pháp hiệu quả giúp bạn chủ động hơn trong cuộc phỏng vấn.

    Nhà tuyển dụng muốn nghe gì ở bạn?

    Một phần giới thiệu ngắn gọn về quá trình học tập và kinh nghiệm làm việc.
    Những điểm mạnh của bản thân có liên quan đến vị trí công việc mà bạn đang phỏng vấn.
    Thành quả bạn đã đạt được trong công việc trước đó, và sự hiểu biết của bạn về những nhiệm vụ bạn sẽ phải làm ở vị trí công việc sắp tới, cùng với bản ghi nhận thành tích cá nhân.
    Cách bạn nhìn nhận về sự đóng góp của bản thân với công việc mà bạn đang hướng đến.
    Bạn nên thể hiện như thế nào?

    Hãy trả lời câu hỏi của mình một cách ngắn gọn. Không ít hơn 60 giây những cũng đừng quá 2 phút. Bạn nên nhớ đây chỉ là câu hỏi để mở đầu cuộc phỏng vấn, bởi vậy bạn hoàn toàn có cơ hội thể hiện bản thân ở các câu hỏi tiếp theo.
    Để chuẩn bị tốt hơn cho câu trả lời của mình, bạn hãy chuẩn bị trước và tập luyện kĩ càng cho đến khi phần trả lời của bạn trở nên hoàn toàn tự nhiên và hoàn chỉnh.
    Ngoài ra, ngôn ngữ cơ thể của bạn cũng đóng vai trò quan trọng vì các nhà tuyển dụng sẽ không dừng lại ở việc nghe câu trả lời mà còn đánh giá bạn qua những đường nét cơ thể. Một ánh mắt chân thành, một dáng ngồi vững chãi, một giọng nói thiện cảm sẽ để lại nhiều ấn tượng tốt đẹp.
    Câu trả lời của bạn nên nhấn mạnh vào những ưu điểm của bản thân như sự thông minh, lòng nhiệt tình, tự tin và sự chuyên nghiệp.
    Khi trả lời câu hỏi, bạn hãy thể hiện bằng thái độ tích cực và khiêm tốn, tránh thái độ tiêu cực, tự mãn hoặc khoe khoang hay khoác lác.
    Nếu bạn đã từng xem các cuộc phỏng vấn của một chính trị gia hoặc một nhà chuyên môn trên TV hoặc radio, bạn sẽ thấy rằng hầu hết các câu trả lời của họ đều có lối mở đầu khá giống nhau, ví dụ "Tôi cho rằng đây quả là một câu hỏi thú vị", và sau đó bạn có thể khéo léo trả lời câu hỏi của mình.
    Sau khi kết thúc câu trả lời, bạn hãy lịch sự chờ đợi câu hỏi tiếp theo từ nhà tuyển dụng và hãy chủ động cuộc phỏng vấn của mình.
3. Cách viết thư giới thiệu bản thân
    Khi gặp người mới quen, ai cũng đều phải trải qua quá trình giới thiệu bản thân. Chúng ta nói bất cứ gì mình thích, miễn sao việc tự giới thiệu ấy đáp ứng được yêu cầu giao tiếp trong hoàn cảnh đó, đồng thời không làm người kia cảm thấy khó chịu hay không có thiện cảm.

    Đối với những cuộc gặp gỡ mang tính chất xã giao hay giao lưu đơn thuần, yêu cầu của phần giới thiệu bản thân cũng khá dễ dàng. Tuy nhiên, trong một hoàn cảnh trang trọng hơn, nghiêm túc hơn, lời giới thiệu buộc phải rõ ràng, mạch lạc

    Đơn cử như trong trường hợp phỏng vấn xin việc, trong một cuộc đàm thoại làm ăn, thư công việc hoặc trong hoàn cảnh mang tính chất ngoại giao, lời giới thiệu cần rõ ràng, đầy đủ thông tin và phải tuân theo một số yêu cầu, chuẩn mực của một bài giới thiệu bản thân.

    Mục đích yêu cầu chính của bài giới thiệu bản thân là bố cục phải rõ ràng, đủ ý, mạch lạc, giọng điệu khiêm tốn nhưng tự tin, tuy mềm mỏng nhưng dứt khoát, thành thực nhưng không cục mịch. Bài giới thiệu phải nêu bật được ý chí, tài năng, niềm tin, sự quyết tâm và phải chiếm được tình cảm, sự lưu tâm của người đọc, người nghe.

    Bố cục của một bài giới thiệu nên chia làm sáu phần:

  1. Thông tin khái quát bản thân

    Tên, tuổi, nghề, quê quán, tình trạng hôn nhân.
    Chỗ ở hiện tại, cách liên hệ với bạn.
    Cha, mẹ (không cần kể tên, tuổi) nghề nghiệp, xuất thân... để người khác hiểu thêm chút về xuất thân của mình.
  2. Kinh nghiệm học tập và làm việc

    Học tập

    Trường cấp 3: Khái quát quá trình học tập, môn giỏi, giáo viên yêu thích, thành tích, tại sao chọn trường và ngành đại học của bạn.
    Đại học: Giới thiệu sơ lược về trường và khoa. Nhận xét, cảm tưởng về trường, lớp, bạn, giáo viên, khóa học, thành tích, hoạt động, chiến dịch đã tham gia...
    Làm việc

    Công việc một: Làm sao có được, làm bao lâu, tại sao nghỉ, học được gì từ công việc?
    Công việc hai: Giống như trên...
    Công việc hiện tại: Mô tả sơ lược và ngắn gọn công việc hiện tại, làm gì trong công ty, làm bao lâu, thích không, công việc thú vị không, sẽ đổi việc không?
  3. Quá trình hoàn thiện bản thân

    Đây là phần rất quan trọng, cho dù là nhà tuyển dụng hay đối tác làm ăn, bạn mới... họ đều rất lưu ý bởi vì họ cần biết bạn đã nhận ra khuyết điểm, đấu tranh khắc phục hoặc từ bỏ như nào? Bao nhiêu điều ấy sẽ thể hiện bạn là người thông minh, dũng cảm, có ý chí, cầu tiến, cầu toàn ra sao?

    Bởi vì đây là bài chuẩn bị mẫu về giới thiệu bản thân nên bạn phải viết ra hết tất cả những điều, việc, thói quen, định kiến... nói chung là những thứ trước kia bạn bị hạn chế, thiếu sót, vụng về, tự ti, cạn nghĩ và bạn đã sửa chữa, cải thiện, khắc phục, tiêu trừ ra sao?

    Trong những tình huống giao tiếp với đối tượng và mục đích cụ thể, bạn chỉ nên chọn ra vài điểm thích hợp để nói, không nên kể hết vì dễ trở nên dông dài, gây nhàm chán cho người nghe (có thể nói thêm nếu người nghe muốn biết thêm).

    Bài giới thiệu bản thân rất quan trọng khi đi xin việc.

  4. Tính cách

    Lưu ý là không cần kể thói quen, sở thích hoặc cá tính bản thân vì điều đó là sự riêng tư của bạn, và người nghe không cần biết điều đó. Thậm chí họ còn cảm thấy phiền lòng vì bạn quá thân thiết không cần thiết.

    Bạn có thể kể ra ba tính cách và giải thích ngắn gọn tại sao mình nghĩ vậy.

    Ví dụ, bạn nói mình thân thiện, bạn nên nói một số ý như sau: Tôi thích gặp gỡ và kết bạn, tôi thích nghe người khác nói, chia sẻ quan điểm. Tôi không muốn làm bạn tôi buồn, tôi có nhiều bạn, tôi thích giúp đỡ người khác, tôi không nóng giận, hay mất bình tĩnh một cách dễ dàng, nói lời tục tĩu là không chấp nhận được...

  5. Kế hoạch tương lai

    Một người thông minh luôn biết định hướng cho cuộc sống của mình, dĩ nhiên anh ta cũng biết định hướng và lên kế hoạch cho bất cứ việc gì anh ta sẽ làm. Người nghe sẽ đánh giá cao bạn vì điều đó.

    Bạn nên chia kế họach ra làm hai phần: Ngắn hạn và dài hạn.

    Ngắn hạn: Tìm được việc tốt, học thêm kỹ năng, ngoại ngữ, để dành tiền đóng góp giúp đỡ cho gia đình... Dài hạn: Mở công ty hay việc kinh doanh riêng, học lên cấp cao hơn, xây nhà, đóng góp cho quê hương, đất nước.

    Lưu ý là kế hoạch này không được mâu thuẫn với tính cách, và chuyên môn học vấn của bạn.

  6. Triết lý sống

    Người thành công trước tiên phải là người có ý chí, kỷ luật và nguyên tắc. Người ta nói: "Người sống không chí hướng giống như thuyền không lái, ngựa không cương, lông bông không ra gì".

    Triết lý sống sẽ thể hiện niềm tin cuộc sống, trình độ tư duy và ý chí sinh tồn của bạn. Do vậy, bạn hãy chọn một câu nói, một trích dẫn, một câu danh ngôn mà bạn tin tưởng, yêu thích và hãy giải thích thật súc tích ý nghĩa của nó.

    Đó là những phần nên có trong bài giới thiệu của bạn. Bạn nên tập viết thật nhiều lần, viết bằng tiếng Việt trước, đừng e ngại khả năng văn học khiêm tốn của mình. Tôi nói bạn nghe, sự thật bao giờ cũng là sự thật. Bạn cứ thật lòng, chân tình, cầu thị... thì bài giới thiệu của bạn vẫn hay, đáng tin hơn bất cứ bài văn nào với câu từ bay bổng nhưng không thực tâm.

    Theo kinh nghiệm cá nhân, thường thì học trò của tôi phải viết ít nhất 5 bài bằng tiếng Việt trở lên thì mới có được một bài giới thiệu bản thân tương đối hay, sau đó mới bắt đầu dịch qua tiếng Anh.
                    </pre>

                </div>

            </div>

            <div class="col-sm-4">
                <div class="card-box">
                    <div class="dropdown float-right">
                        <a href="#" class="dropdown-toggle arrow-none card-drop" data-toggle="dropdown" aria-expanded="false">
                            <i class="mdi mdi-dots-vertical"></i>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right">
                            <!-- item-->
                            <a href="javascript:void(0);" class="dropdown-item">Action</a>
                            <!-- item-->
                            <a href="javascript:void(0);" class="dropdown-item">Another action</a>
                            <!-- item-->
                            <a href="javascript:void(0);" class="dropdown-item">Something else</a>
                            <!-- item-->
                            <a href="javascript:void(0);" class="dropdown-item">Separated link</a>
                        </div>
                    </div>

                    <h4 class="header-title mt-0 mb-3">My Team Members</h4>

                    <ul class="list-group mb-0 user-list">
                        <li class="list-group-item">
                            <a href="#" class="user-list-item">
                                <div class="user avatar-sm float-left mr-2">
                                    <img src="/images/users/user-2.jpg" alt="" class="img-fluid rounded-circle">
                                </div>
                                <div class="user-desc">
                                    <h5 class="name mt-0 mb-1">Michael Zenaty</h5>
                                    <p class="desc text-muted mb-0 font-12">CEO</p>
                                </div>
                            </a>
                        </li>

                        <li class="list-group-item">
                            <a href="#" class="user-list-item">
                                <div class="user avatar-sm float-left mr-2">
                                    <img src="/images/users/user-3.jpg" alt="" class="img-fluid rounded-circle">
                                </div>
                                <div class="user-desc">
                                    <h5 class="name mt-0 mb-1">James Neon</h5>
                                    <p class="desc text-muted mb-0 font-12">Web Designer</p>
                                </div>
                            </a>
                        </li>

                        <li class="list-group-item">
                            <a href="#" class="user-list-item">
                                <div class="user avatar-sm float-left mr-2">
                                    <img src="/images/users/user-5.jpg" alt="" class="img-fluid rounded-circle">
                                </div>
                                <div class="user-desc">
                                    <h5 class="name mt-0 mb-1">John Smith</h5>
                                    <p class="desc text-muted mb-0 font-12">Web Developer</p>
                                </div>
                            </a>
                        </li>

                        <li class="list-group-item">
                            <a href="#" class="user-list-item">
                                <div class="user avatar-sm float-left mr-2">
                                    <img src="/images/users/user-6.jpg" alt="" class="img-fluid rounded-circle">
                                </div>
                                <div class="user-desc">
                                    <h5 class="name mt-0 mb-1">Michael Zenaty</h5>
                                    <p class="desc text-muted mb-0 font-12">Programmer</p>
                                </div>
                            </a>
                        </li>

                        <li class="list-group-item">
                            <a href="#" class="user-list-item">
                                <div class="user avatar-sm float-left mr-2">
                                    <img src="/images/users/user-1.jpg" alt="" class="img-fluid rounded-circle">
                                </div>
                                <div class="user-desc">
                                    <h5 class="name mt-0 mb-1">Mat Helme</h5>
                                    <p class="desc text-muted mb-0 font-12">Manager</p>
                                </div>
                            </a>
                        </li>
                    </ul>
                </div>

                <div class="card-box">
                    <div class="dropdown float-right">
                        <a href="#" class="dropdown-toggle arrow-none card-drop" data-toggle="dropdown" aria-expanded="false">
                            <i class="mdi mdi-dots-vertical"></i>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right">
                            <!-- item-->
                            <a href="javascript:void(0);" class="dropdown-item">Action</a>
                            <!-- item-->
                            <a href="javascript:void(0);" class="dropdown-item">Another action</a>
                            <!-- item-->
                            <a href="javascript:void(0);" class="dropdown-item">Something else</a>
                            <!-- item-->
                            <a href="javascript:void(0);" class="dropdown-item">Separated link</a>
                        </div>
                    </div>

                    <h4 class="header-title mt-0 mb-3"><i class="mdi mdi-notification-clear-all mr-1"></i> Upcoming Reminders</h4>

                    <ul class="list-group mb-0 user-list">
                        <li class="list-group-item">
                            <a href="#" class="user-list-item">
                                <div class="user float-left mr-3">
                                    <i class="mdi mdi-circle text-primary"></i>
                                </div>
                                <div class="user-desc overflow-hidden">
                                    <h5 class="name mt-0 mb-1">Meet Manager</h5>
                                    <span class="desc text-muted font-12 text-truncate d-block">February 24, 2019 - 10:30am to 12:45pm</span>
                                </div>
                            </a>
                        </li>

                        <li class="list-group-item">
                            <a href="#" class="user-list-item">
                                <div class="user float-left mr-3">
                                    <i class="mdi mdi-circle text-success"></i>
                                </div>
                                <div class="user-desc overflow-hidden">
                                    <h5 class="name mt-0 mb-1">Project Discussion</h5>
                                    <span class="desc text-muted font-12 text-truncate d-block">February 25, 2019 - 10:30am to 12:45pm</span>
                                </div>
                            </a>
                        </li>

                        <li class="list-group-item">
                            <a href="#" class="user-list-item">
                                <div class="user float-left mr-3">
                                    <i class="mdi mdi-circle text-pink"></i>
                                </div>
                                <div class="user-desc overflow-hidden">
                                    <h5 class="name mt-0 mb-1">Meet Manager</h5>
                                    <span class="desc text-muted font-12 text-truncate d-block">February 26, 2019 - 10:30am to 12:45pm</span>
                                </div>
                            </a>
                        </li>

                        <li class="list-group-item">
                            <a href="#" class="user-list-item">
                                <div class="user float-left mr-3">
                                    <i class="mdi mdi-circle text-muted"></i>
                                </div>
                                <div class="user-desc overflow-hidden">
                                    <h5 class="name mt-0 mb-1">Project Discussion</h5>
                                    <span class="desc text-muted font-12 text-truncate d-block">February 27, 2019 - 10:30am to 12:45pm</span>
                                </div>
                            </a>
                        </li>

                        <li class="list-group-item">
                            <a href="#" class="user-list-item">
                                <div class="user float-left mr-3">
                                    <i class="mdi mdi-circle text-danger"></i>
                                </div>
                                <div class="user-desc overflow-hidden">
                                    <h5 class="name mt-0 mb-1">Meet Manager</h5>
                                    <span class="desc text-muted font-12 text-truncate d-block">February 28, 2019 - 10:30am to 12:45pm</span>
                                </div>
                            </a>
                        </li>
                    </ul>
                </div>


            </div>
        </div>

    </div> <!-- container-fluid -->

@endsection
