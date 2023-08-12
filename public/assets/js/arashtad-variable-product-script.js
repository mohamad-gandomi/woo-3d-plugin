jQuery(document).ready(function($) {

    // Bind a function to the 'found_variation' event
    $('form.variations_form').on('found_variation', function(event, variation) {
        // Get the selected variation ID
        var selectedVariationID = variation.variation_id;

        // Hide all canvases except the selected one
        $('#canvas canvas').hide()
        $('.mg-variation-image').hide()
        $('.mg-variation-image[data-variation-id="' + selectedVariationID + '"]').show()
        $('#canvas canvas[data-variation-id="' + selectedVariationID + '"]').show();
    });

    var canvasContainer = $('#canvas');
    $.each(metaData, function(key, value) {
        if (value.type === 'model') {
            
            var canvas = $('<canvas id="productScene" data-variation-id="'+ value.variationId +'" ></canvas>');
            canvasContainer.append(canvas);
            var canvas = $('canvas[data-variation-id="' + value.variationId + '"]')[0]
            var engine = new BABYLON.Engine(canvas, true);
            var scene = new BABYLON.Scene(engine);
            
            // Enviroment background color
            if (value.envBackgroundColor) {

                var colorString = value.envBackgroundColor;
                var colorComponents = colorString.split(',');
                var red = parseFloat(colorComponents[0]);
                var green = parseFloat(colorComponents[1]);
                var blue = parseFloat(colorComponents[2]);
                var alpha = parseFloat(colorComponents[3]);

                scene.clearColor = new BABYLON.Color4(red, green, blue, alpha);
            }

            // Create a default skybox with an environment.
            var hdrTexture = BABYLON.CubeTexture.CreateFromPrefilteredData(value.modelEnv, scene);
            var currentSkybox = scene.createDefaultSkybox(hdrTexture, true);
            currentSkybox.name = "arashtad-environment";

            // Hide skybox if enviroment background color is enabled
            if (value.showEnvBackgroundColor) {
                currentSkybox.visibility = false;
            }

            engine.loadingUIBackgroundColor = "transparent";
            BABYLON.SceneLoaderFlags.ShowLoadingScreen = false;

            // Append glTF model to scene.
            BABYLON.SceneLoader.Append(value.modelDirectory, value.modelName, scene, function (scene) {
                // Create a default arc rotate camera and light.
                scene.createDefaultCameraOrLight(true, true, true);

                // The default camera looks at the back of the asset.
                // Rotate the camera by 180 degrees to the front of the asset.
                scene.activeCamera.alpha += Math.PI;

                scene.activeCamera.lowerRadiusLimit = value.minZoom;
                scene.activeCamera.upperRadiusLimit = value.maxZoom;
                scene.activeCamera.wheelPrecision = value.wheelSpeed;

                if(engine.hideLoadingUI) {
                    document.body.classList.add("loaded");
                }

                for(var i = 0; i < scene.meshes.length; i++) {
                    if(scene.meshes[i].name != "__root__") {
                        scene.meshes[i].scaling = new BABYLON.Vector3(value.modelDisplaySize, value.modelDisplaySize, value.modelDisplaySize);
                    }
                }

                engine.runRenderLoop(function () {
                    scene.render();
                });

                if (!document.body.classList.contains('loaded')) {
                    document.body.classList.add('loaded');
                }

            });
            
            // Resize
            window.addEventListener("resize", function () { engine.resize();});


        } else if (value.type === 'image') {
            var image = $('<img src="'+ value.image.url +'" alt="'+ value.image.caption +'" data-variation-id="'+ value.variationId +'" >');
            canvasContainer.append(image);
        } else if (value.type === 'error') {
            var error = $('<div class="alert error">'+ value.message +'</div>')
            canvasContainer.append(error)
        }
    });
});
