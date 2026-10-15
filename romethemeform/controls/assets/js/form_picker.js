window.addEventListener("elementor/init", () => {
  var form_select = elementor.modules.controls.BaseData.extend({
    onReady: function () {
      var cur_val = this.getControlValue();

      /*
       * ============================================================
       * ELEMENT REFERENCES
       * ============================================================
       */

      this.form_select = this.$el.find(".rform-select-form");

      this.form_radio_select = this.$el.find(".rform-radio-btn");

      this.form_editform_btn = this.$el.find(".rform-editform-btn");

      this.modal_container = this.$el.find(".rform-modal-content");

      this.form_select_edit = this.$el.find(".rform-select-edit");

      this.hidden_form_id = this.$el.find(".hidden-form_id");

      this.select_save_btn = this.$el.find(".rform-select-savebtn");

      this.new_save_btn = this.$el.find(".rform-new-savebtn");

      /*
       * ============================================================
       * INITIAL VALUE
       * ============================================================
       */

      this.form_select.val(cur_val).trigger("change");
      /*
       * ============================================================
       * FORM TYPE / MODAL TABS
       * ============================================================
       */

      this.form_radio_select.on("click", (e) => {
        var selectedContent = e.currentTarget.dataset.content;

        console.log(selectedContent);

        this.$el.find(".rform-tab-content").not(selectedContent).hide();

        this.$el.find(selectedContent).show();
      });

      /*
       * ============================================================
       * OPEN EDIT FORM MODAL
       * ============================================================
       */

      this.form_editform_btn.on("click", () => {
        var $editForm = this.form_editform_btn.closest(".rform-editform");

        var $modal = $editForm.find(".rform-editform-modal");

        $modal.toggle();

        var selectedContent = $modal
          .find(".rform-radio-btn:checked")
          .data("content");

        if (selectedContent) {
          this.$el.find(selectedContent).show();
        }
      });

      /*
       * ============================================================
       * CLOSE MODAL
       * ============================================================
       */

      this.$el.on("click", ".rform-close-btn", (e) => {
        e.preventDefault();

        this.$el.find(".rform-editform-modal").hide();
      });

      /*
       * ============================================================
       * SAVE & CLOSE FORM EDITOR
       *
       * This saves the Elementor editor inside iframe.
       * ============================================================
       */

      this.$el.on("click", "#rform-editform-button", (e) => {
        e.preventDefault();

        var $this = jQuery(e.currentTarget);

        $this.html("SAVING...");
        $this.attr("disabled", true);

        var uid = $this.data("control-uid");

        var modal = jQuery("#myModal" + uid);

        var iframe = window.parent.document.getElementById("ifr-" + uid);

        if (!iframe) {
          console.error("RForm: Elementor iframe not found.", "ifr-" + uid);

          $this.html("SAVE & CLOSE");
          $this.removeAttr("disabled");

          return;
        }

        var iframeWindow = iframe.contentWindow;

        if (!iframeWindow || !iframeWindow.elementor) {
          console.error("RForm: Elementor instance not found inside iframe.");

          $this.html("SAVE & CLOSE");
          $this.removeAttr("disabled");

          return;
        }

        var elementorEditor = iframeWindow.elementor;

        var panel = elementor.getPanelView();

        /*
         * Get the currently edited widget
         */
        var currentSelectedWidget = panel
          .getCurrentPageView()
          .getOption("editedElementView");

        /*
         * Save Elementor editor
         */
        elementorEditor.saver.saveEditor({
          status: elementorEditor.settings.page.model.get("post_status"),

          onSuccess: function () {
            modal.hide();

            /*
             * Refresh the current widget in the parent Elementor
             */
            if (currentSelectedWidget) {
              currentSelectedWidget.renderOnChange();
            }

            /*
             * Clear iframe
             */
            iframe.src = "";

            $this.html("SAVE & CLOSE");

            $this.removeAttr("disabled");
          },

          onError: function () {
            alert("Error saving Form");

            $this.html("SAVE & CLOSE");

            $this.removeAttr("disabled");
          },
        });
      });

      /*
       * ============================================================
       * SAVE SELECTED FORM
       * ============================================================
       */

      this.select_save_btn.on("click", () => {
        this.val = this.form_select.val();

        this.saveValue();

        this.$el.find(".rform-editform-modal").hide();
      });

      /*
       * ============================================================
       * EDIT SELECTED FORM
       * ============================================================
       */

      this.form_select_edit.on("click", () => {
        this.val = this.form_select.val();

        this.saveValue();

        this.$el.find(".rform-editform-modal").hide();

        var url =
          adminData.adminUrl +
          "post.php?post=" +
          this.form_select.val() +
          "&action=elementor";

        this.$el.find(".rform-ifr-editor").attr("src", url);

        this.$el.find(".rform-editor-modal").show();
      });

      /*
       * ============================================================
       * CREATE NEW FORM
       * ============================================================
       */

      this.new_save_btn.on("click", () => {
        var $button = this.new_save_btn;

        var form_data = $button
          .closest("#tab-content-new")
          .find("#rform-newform")
          .serialize();

        $button.html("Saving...");
        $button.prop("disabled", true);

        var nonce = adminData.nonce;

        var data = form_data + "&nonce=" + nonce;

        jQuery.ajax({
          type: "POST",

          url: adminData.ajax_url,

          data: data,

          success: (e) => {
            /*
             * Set new form as selected value
             */
            this.val = e.data.form_id;

            this.saveValue();

            /*
             * Close form selection modal
             */
            this.$el.find(".rform-editform-modal").hide();

            /*
             * Open newly created form in Elementor iframe
             */
            var url =
              adminData.adminUrl +
              "post.php?post=" +
              e.data.form_id +
              "&action=elementor";

            this.$el.find(".rform-ifr-editor").attr("src", url);

            this.$el.find(".rform-editor-modal").show();

            /*
             * Reset button
             */
            $button.html("Save & Edit");

            $button.removeProp("disabled");

            /*
             * Add newly created form to select
             */
            var new_opt = jQuery("<option>", {
              value: e.data.form_id,
              text: e.data.form_name,
              selected: true,
            });

            this.$el.find(".rform-select-form").append(new_opt);

            /*
             * Reset new form
             */
            this.$el.find("#rform-newform").trigger("reset");

            /*
             * Switch back to Select tab
             */
            this.$el.find("#tab-select").prop("checked", true);

            this.$el.find("#tab-content-new").hide();
          },

          error: () => {
            $button.html("Save & Edit");

            $button.removeProp("disabled");

            alert("Error creating form.");
          },
        });
      });

      /*
       * ============================================================
       * GENERAL TABS
       *
       * .tab-item / .tab-pane
       * ============================================================
       */

      this.$el.on("click", ".tab-item", (e) => {
        e.preventDefault();

        var $tab = jQuery(e.currentTarget);

        this.$el.find(".tab-item").removeClass("active");

        $tab.addClass("active");

        var tabId = $tab.attr("data-tab");

        this.$el.find(".tab-pane").removeClass("active");

        this.$el.find("#" + tabId).addClass("active");
      });

      /*
       * ============================================================
       * CONFIRMATION SWITCH
       * ============================================================
       */

      this.$el.on("click", "#switch_confirmation", (e) => {
        var checked = jQuery(e.currentTarget).prop("checked");

        if (checked) {
          this.$el.find("#confirmation_form").show();
        } else {
          this.$el.find("#confirmation_form").hide();
        }
      });

      /*
       * ============================================================
       * NOTIFICATION SWITCH
       * ============================================================
       */

      this.$el.on("click", "#switch_notification", (e) => {
        var checked = jQuery(e.currentTarget).prop("checked");

        if (checked) {
          this.$el.find("#notification_form").show();
        } else {
          this.$el.find("#notification_form").hide();
        }
      });
    },

    /*
     * ============================================================
     * SAVE CONTROL VALUE
     * ============================================================
     */

    saveValue: function () {
      this.setValue(this.val);
    },
  });

  /*

* ==============================================================
* REGISTER ELEMENTOR CONTROL
* ==============================================================
  */

  elementor.addControlView("rform_control", form_select);
});
