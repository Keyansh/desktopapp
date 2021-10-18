<div id="dialog-modal" title="Working">
    <p style="text-align: center; padding-top: 40px;">Updating the sort order...</p>
</div>

<div id="pageBuilderElementsModel" class="modal fade" role="dialog" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <ul class="list-inline elementSelection-header-list">
                    <li>
                        <h3 class="modal-title">Add Element</h3>
                    </li>
                    <li>
                        <div class="input-search-div">
                            <input id="listsearch" class="form-control" type="text" placeholder="Search..">
                        </div>
                    </li>
                </ul>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <ul id="pageBuilderOptionList">
                    <?php foreach ($pagebuiltderElements as $item) {?>
                        <li data-element-item='<?php echo json_encode($item); ?>'
                            data-page-id="<?=$pages['page_id']?>" >
                            <img src="<?php echo $this->config->item('ELEMENT_ICON_URL') . $item['element_icon']; ?>" width="48" alt="">
                            <?=$item['element_name']?>
                        </li>
                    <?php }?>
                </ul>
            </div>
        </div>

    </div>
</div>

<div id="rowLayoutSelector">
    <form action="" method="POST" enctype="multipart/form-data" id="insertRowAndColumnForm">
        <div class="modal-body">
            <div class="form-group">
                <p>Row Layout</p>
            </div>
            <div class="form-group" style="margin: 0px;">
                <ul class="list-inline radio-ul">
                    <li>
                        <label><input type="radio" name="layout_type" value="full_column" checked> <span class="radio-icon a1"></span></label>
                    </li>
                    <li>
                        <label><input type="radio" name="layout_type" value="half_column"> <span class="radio-icon a2"></span></label>
                    </li>
                    <li>
                        <label><input type="radio" name="layout_type" value="three_column"> <span class="radio-icon a3"></span></label>
                    </li>
                    <li>
                        <label><input type="radio" name="layout_type" value="four_column"> <span class="radio-icon a4"></span></label>
                    </li>
                    <li>
                        <label><input type="radio" name="layout_type" value="five_column"> <span class="radio-icon a5"></span></label>
                    </li>
                    <li>
                        <label><input type="radio" name="layout_type" value="left_column"> <span class="radio-icon a6"></span></label>
                    </li>
                    <li>
                        <label><input type="radio" name="layout_type" value="right_column"> <span class="radio-icon a7"></span></label>
                    </li>
                    <li>
                        <label><input type="radio" name="layout_type" value="center_column"> <span class="radio-icon a8"></span></label>
                    </li>
                </ul>
            </div>
        </div>

        <div class="modal-footer">
            <input type="hidden" name="page_id" value="<?php echo $pages['page_id']; ?>">
            <button type="submit" class="btn btn-info">Submit</button>
            <a id="close-rowLayoutSelector" href="#" class="btn btn-info">Close</a>
        </div>
    </form>
</div>

<div id="pageBuilderWidgetsModel" class="modal fade" role="dialog" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">

            <div class="modal-body col-xs-12">

                <ul class="nav nav-tabs" style="padding: 0;">
                    <li class="nextmenu active"><a data-toggle="tab" href="#menu1">Content</a></li>
                    <li class="firsttab"><a data-toggle="tab" href="#home">Style</a></li>
                </ul>

                <div class="tab-content">
                    <div class="alert alert-danger" id="enquiryAlert" style="display: none;"></div>
                    <div id="menu1" class="tab-pane fade in active">
                        <div id="loadelementform">
                            loading..
                        </div>
                    </div>
                    <div id="home" class="tab-pane fade ">
                        <div id="loaddata">
                            loading..
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-info close-btn-disable">Close</button>
                <button type="submit" form="pagebuilderElementformdata" id="submitformdataWidgets" class="btn btn-info">Submit</button>
            </div>
        </div>
    </div>
</div>

<div id="myModalNK" class="modal fade" role="dialog" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog" style="width: 800px;">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Modal Header</h4>
            </div>
            <div class="modal-body">
                <p class="cropperDimesionData">
                    Height: <span id="cropperHeight"></span> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Width: <span id="cropperWidth"></span>
                </p>
                <div class="img-container">
                    <img id="imagenk" class="img-responsive" src="https://avatars0.githubusercontent.com/u/3456749">
                </div>

                <div class="btn-group">
                    <button type="button" class="btn btn-primary" data-method="rotate" data-option="-45" title="Rotate Left" onclick="cropper.rotate(-45)">
                        <span class="docs-tooltip" data-toggle="tooltip" title="cropper.rotate(-45)">
                            <span class="fa fa-rotate-left"></span>
                        </span>
                    </button>
                    <button type="button" class="btn btn-primary" data-method="rotate" data-option="45" title="Rotate Right" onclick="cropper.rotate(45)">
                        <span class="docs-tooltip" data-toggle="tooltip" title="cropper.rotate(45)">
                            <span class="fa  fa-rotate-right"></span>
                        </span>
                    </button>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary" id="crop">Crop</button>
            </div>
        </div>
    </div>
</div>

<div id="rowUpdate" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Update Row</h4>
      </div>
      <div class="modal-body">
            <p>Loading...</p>
      </div>
      <!-- <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div> -->
    </div>

  </div>
</div>

<div id="sidebarModal" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Page Sidebar</h4>
            </div>
            <div class="modal-body">
                <form id="sidebarForm" method="POST">
                     <div class="col-xs-12 form-group">
                         <label class="col-xs-12 col-sm-3">Sidebar position</label>
                         <div class="col-xs-12 col-sm-6">
                            <ul class="list-inline">
                                <li>
                                    <label class="custom-check-field-label custom-radio-check">
                                        <input type="radio" name="sidebar_layout" value="left-side" <?php echo $pages['sidebar_layout'] == 'left-side' ? 'checked' : ''; ?> /> 
                                        <span class="box">
                                            <i class="fa fa-circle"></i>
                                        </span>
                                        <span class="text">Left</span>
                                    </label>
                                </li>
                                <li>
                                    <label class="custom-check-field-label custom-radio-check">
                                        <input type="radio" name="sidebar_layout" value="right-side" <?php echo $pages['sidebar_layout'] == 'right-side' ? 'checked' : ''; ?> /> 
                                        <span class="box">
                                            <i class="fa fa-circle"></i>
                                        </span>
                                        <span class="text">Right</span>
                                    </label>
                                </li>
                            </ul>
                         </div>
                     </div>
                     <div class="col-xs-12 form-group">
                         <label class="col-xs-12 col-sm-3">Sidebar width (%)</label>
                         <div class="col-xs-12 col-sm-6">
                             <input class="form-control" type="number" name="page_sidebar_width" placeholder="Default is 30" id="" value="<?php echo $pages['page_sidebar_width'] ? $pages['page_sidebar_width'] : '40'; ?>">
                             <p style="color: grey;"><small>Default is 30</small></p>
                         </div>
                     </div>
                     <div class="col-xs-12 form-group text-center">
                        <input type="hidden" name="page_id" value="<?= $pages['page_id']  ?>">
                        <input type="hidden" name="page_template_id" value="<?= $pages['page_template_id']  ?>">
                        <input type="submit" class="btn btn-primary btn-lg" value="Submit" />
                     </div>
                </form>
            </div>
        </div>
    </div>
</div>

<div id="sideMenuModal" class="modal fade" role="dialog" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Modal Header</h4>
            </div>
            <div class="modal-body">
                <form id="sideMenuForm" method="POST">
                    <div class="form-group">
                        <label>Menu</label>
                        <select class="form-control menu-selector" name="menu_id[]" id="" multiple="multiple">
                            <?php if(isset($sideMenus) && $sideMenus){ 
                                foreach($sideMenus as $sideMenu){
                                ?>
                                <option value="<?php echo $sideMenu['menu_id']; ?>" <?php echo in_array($sideMenu['menu_id'], json_decode($pages['sidebar_menu_id'], true)) ? 'selected' : ''; ?>><?php echo $sideMenu['menu_name']; ?></option>
                            <?php 
                                }
                            } ?>
                        </select>
                    </div>
                    <div class="form-group text-center">
                        <input type="hidden" name="page_id" value="<?= $pages['page_id']  ?>">
                        <input type="submit" class="btn btn-primary btn-lg" value="Add Menu" />
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<div id="pageTemplateModal" class="modal fade" role="dialog">
    <div class="modal-dialog">

        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Save page template</h4>
            </div>
            <div class="modal-body">
                <form id="pageTemplateForm" method="post">
                    <div class="alert" id="templateAlert" style="display: none;"></div>
                    <div class="form-group">
                        <label>Template Name</label>
                        <input class="form-control" type="text" name="template_name" id="" />
                    </div>
                    <div class="form-group text-right">
                        <input type="hidden" name="page_id" value="<?= $pages['page_id']  ?>">
                        <input class="btn btn-primary btn-lg" type="submit" value="Save" />
                    </div>
                </form>
            </div>
        </div>

    </div>
</div>

<?php if($pageTemplates){ ?>
    <div id="templateAssignModal" class="modal fade" role="dialog">
        <div class="modal-dialog">

            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Assign template</h4>
                </div>
                <div class="modal-body">
                    <form id="templateAssignForm" method="post">
                        <div class="alert" id="templateAssignAlert" style="display: none;"></div>
                        <div class="form-group">
                            <label>Select Template</label>
                            <select name="template_id" id="" class="form-control">
                                <?php foreach($pageTemplates as $pageTemplate){ ?>
                                    <option value="<?php echo $pageTemplate['id']; ?>"><?php echo $pageTemplate['template_name']; ?></option>
                                <?php } ?>
                            </select>
                        </div>
                        <div class="form-group text-right">
                            <input type="hidden" name="page_id" value="<?= $pages['page_id']  ?>">
                            <input class="btn btn-primary btn-lg" type="submit" value="Save" />
                        </div>
                    </form>
                </div>
            </div>

        </div>
    </div>
<?php } ?>
