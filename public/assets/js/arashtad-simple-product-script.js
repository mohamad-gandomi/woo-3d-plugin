var canvas = document.getElementById("productScene");

var startRenderLoop = function (engine, canvas) {
    engine.runRenderLoop(function () {
        if (sceneToRender && sceneToRender.activeCamera) {
            sceneToRender.render();
        }
    });
}

var engine = null;
var scene = null;
var sceneToRender = null;
var createDefaultEngine = function() { return new BABYLON.Engine(canvas, true, { preserveDrawingBuffer: true, stencil: true,  disableWebGL2Support: false}); };
var delayCreateScene = function () {
    // Create a scene.
    var scene = new BABYLON.Scene(engine);

    // Enviroment background color
    if (metaData.envBackgroundColor) {

        var colorString = metaData.envBackgroundColor;
        var colorComponents = colorString.split(',');
        var red = parseFloat(colorComponents[0]);
        var green = parseFloat(colorComponents[1]);
        var blue = parseFloat(colorComponents[2]);
        var alpha = parseFloat(colorComponents[3]);

        scene.clearColor = new BABYLON.Color4(red, green, blue, alpha);
    }

    // Create a default skybox with an environment.
    var hdrTexture = BABYLON.CubeTexture.CreateFromPrefilteredData(metaData.modelEnv, scene);
    var currentSkybox = scene.createDefaultSkybox(hdrTexture, true);
    currentSkybox.name = "arashtad-environment";

    // Hide skybox if enviroment background color is enabled
    if (metaData.showEnvBackgroundColor) {
        currentSkybox.visibility = false;
    }

    engine.loadingUIBackgroundColor = "transparent";
    BABYLON.SceneLoaderFlags.ShowLoadingScreen = false;

    // Append glTF model to scene.
    BABYLON.SceneLoader.Append(metaData.modelDirectory, metaData.modelName, scene, function (scene) {
        // Create a default arc rotate camera and light.
        scene.createDefaultCameraOrLight(true, true, true);

        // The default camera looks at the back of the asset.
        // Rotate the camera by 180 degrees to the front of the asset.
        scene.activeCamera.alpha += Math.PI;

        scene.activeCamera.lowerRadiusLimit = metaData.minZoom;
        scene.activeCamera.upperRadiusLimit = metaData.maxZoom;
        scene.activeCamera.wheelPrecision = metaData.wheelSpeed;

        if(engine.hideLoadingUI) {
            document.body.classList.add("loaded");
        }

        for(var i = 0; i < scene.meshes.length; i++) {
            if(scene.meshes[i].name != "__root__") {
                scene.meshes[i].scaling = new BABYLON.Vector3(metaData.modelDisplaySize, metaData.modelDisplaySize, metaData.modelDisplaySize);
            }
        }

    });

    return scene;
};

window.initFunction = async function() {
    
    var asyncEngineCreation = async function() {
        try {
        return createDefaultEngine();
        } catch(e) {
        console.log("the available createEngine function failed. Creating the default engine instead");
        return createDefaultEngine();
        }
    }

    window.engine = await asyncEngineCreation();

    if (!engine) throw 'engine should not be null.';
    startRenderLoop(engine, canvas);
    window.scene = delayCreateScene();
};

initFunction().then(() => {sceneToRender = scene });

// Resize
window.addEventListener("resize", function () { engine.resize();});