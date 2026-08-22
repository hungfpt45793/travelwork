 <aside class="left left-content col-lg-3 col-md-3 col-sm-12 col-xs-12 col-lg-pull-9 col-md-pull-9">
                     <aside class="aside-item collection-category blog_cate">
                        <div class="title_module">
                           <h2><span>Danh mục tin tức</span></h2>
                        </div>
                        <div class="aside-content aside-cate-link-cls aside-cate-blog">
                           <nav class="cate_padding nav-category navbar-toggleable-md">
                              <ul class="nav-ul nav navbar-pills">
                                 @foreach (\App\Entity\Menu::showWithLocation('sider-bar-blog') as $Mainmenu_left)
                                    @foreach (\App\Entity\MenuElement::showMenuPageArray($Mainmenu_left->slug) as $idLeft=>$menuelement_left)
                                 <li class="nav-item">
                                    <a class="nav-link" href="{{ $menuelement_left['url']}}">{{ $menuelement_left['title_show']}}</a>
                                 </li>
                                  @endforeach
                                 @endforeach
                                
                              </ul>
                           </nav>
                           <span class="border-das-sider"></span>
                        </div>
                     </aside>
                     <div class="aside-item">
                        <div>
                           <div class="title_title">
                              <h2><a href="blog-tu-van" title="Tin tức nổi bật">Tư vấn</a></h2>
                           </div>
                           <div class="list-blogs">
                              <div class="blog_list_item">
                                   @foreach(\App\Entity\Post::categoryShow('tin-tuc-noi-bat',3) as $post)
                                 <article class="blog-item blog-item-list ">
                                    <div class="blog-item-thumbnail img1" onclick="window.location.href='{{ route('post', ['cate_slug' => 'tin-tuc', 'post_slug' => $post->slug]) }}';">
                                       <a href="{{ route('post', ['cate_slug' => 'tin-tuc', 'post_slug' => $post->slug]) }}">
                                          <div class="CropImg CropImg70">
                                             <div class="thumbs">
                                                <picture>

                                                   <img src="{{ isset($post['image']) ? $post['image'] : ''}}
                                                   " style="max-width:100%;" class="img-responsive lazy" alt="">
                                                </picture>
                                             </div>
                                          </div>
                                       </a>
                                    </div>
                                    <div class="ct_list_item">
                                       <h3 class="blog-item-name"><a class="text2line" href="{{ route('post', ['cate_slug' => 'tin-tuc', 'post_slug' => $post->slug]) }}" title="2{{ isset($post['title']) ? $post['title'] : '' }}">{{ isset($post['title']) ? $post['title'] : '' }}</a></h3>
                                       <span class="time_post"><i class="ion-clock"></i>{{ isset($post['updated_at']) ? $post['updated_at'] : '' }}</span>
                                    </div>
                                 </article>
                                 @endforeach
                                 
                              </div>
                           </div>
                        </div>
                     </div>
                  </aside>