<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Number/Text to Text Translator</title>
    <!-- Add Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-image: url('images/2.jpg');
            background-size: cover;
            background-position: center;
        }

        

        nav {
            background-color: rgba(255, 255, 255, 0.7);
            padding: 10px;
            text-align: center;
        }

        nav a {
            color: Black;
            font-size: 18px;
            margin: 0 15px;
            text-decoration: none;
        }

        nav a:hover {
            text-decoration: underline;
        }

        .container {
            max-width: 1200px;

            margin: 30px auto;
            padding: 20px;
            border-radius: 10px;
            background-color: rgba(255, 255, 255, 0.7);
        }

        .card {
            background-color: rgba(255, 255, 255, 0.7);
            padding: 30px;
            border-radius: 10px;
        }

        .btn-small {
            font-size: 14px;
            width: 48%;
        }

        .result {
            font-family: 'Times New Roman', Times, serif;
            font-size: 18px;
            color: #333;
            margin-top: 20px;
            padding: 15px;
            background-color: rgba(255, 255, 255, 0.9);
            border-radius: 8px;
            line-height: 1.6;
        }
    </style>
</head>

<body>

    <div class="blurred-background"></div>

    <nav style="display: flex; align-items: center; padding: 10px; background-color: #f8f9fa;">
    <a href="#" style="text-decoration: none; font-size: 18px; font-weight: bold; color: #333;">
        NUMBER TO TEXT TRANSLATOR.
    </a>
</nav>

    <div class="container mt-5">
    <div class="row">
        <!-- Converter Section -->
        <div class="col-md-6">
            <div class="card">
                <form method="POST">
                    <div class="row align-items-center">
                        <div class="col-md-12 mb-3">
                            <label for="input_value" class="form-label">Enter Number/Text:</label>
                            <textarea name="input_value" id="input_value" class="form-control" rows="4"
                                placeholder="Enter text or number" required><?= isset($_POST['input_value']) ? $_POST['input_value'] : '' ?></textarea>
                        </div>
                        <div class="col-md-12">
                            <div class="row g-2">
                                <div class="col-4"><button type="submit" name="language" value="en" class="btn btn-info btn-small w-100">English</button></div>
                                <div class="col-4"><button type="submit" name="language" value="hi" class="btn btn-info btn-small w-100">Hindi</button></div>
                                <div class="col-4"><button type="submit" name="language" value="ta" class="btn btn-info btn-small w-100">Tamil</button></div>
                                <div class="col-4"><button type="submit" name="language" value="kn" class="btn btn-info btn-small w-100">Kannada</button></div>
                                <div class="col-4"><button type="submit" name="language" value="ml" class="btn btn-info btn-small w-100">Malayalam</button></div>
                                <div class="col-4"><button type="submit" name="language" value="te" class="btn btn-info btn-small w-100">Telugu</button></div>
                            </div>
                        </div>
                    </div>
                </form>
                <?php
                if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                    $inputValue = $_POST['input_value'];
                    $language = $_POST['language'];

                    function convertInput($input, $locale)
                    {
                        if (is_numeric($input)) {
                            $formatter = new NumberFormatter($locale, NumberFormatter::SPELLOUT);
                            $native = $formatter->format($input);

                            try {
                                $romanized = ($locale === 'en') 
                                    ? $native 
                                    : transliterator_transliterate("$locale-Latin", $native);
                            } catch (Exception $e) {
                                $romanized = "Romanization not available for $locale.";
                            }

                            return ['native' => $native, 'romanized' => $romanized];
                        } else {
                            try {
                                $native = ($locale === 'en') 
                                    ? $input 
                                    : transliterator_transliterate("Any-$locale", $input);

                                $romanized = ($locale === 'en') 
                                    ? $input 
                                    : transliterator_transliterate("$locale-Latin", $native);
                            } catch (Exception $e) {
                                $native = "Transliteration not supported for this language.";
                                $romanized = "Romanization not supported for $locale.";
                            }

                            return ['native' => $native, 'romanized' => $romanized];
                        }
                    }

                    $result = convertInput($inputValue, $language);

                    echo "<div class='result'>
                            <h2>Result:</h2>
                            <p><strong>Native Script:</strong> {$result['native']}</p>
                            <p><strong>Romanized:</strong> {$result['romanized']}</p>
                          </div>";
                }
                ?>
            </div>
        </div>

        <!-- Translator Section -->
        <div class="col-md-6">
            <div class="card">
                <h4 class="text-center mb-4">GOOGLE TRANSLATOR</h4>
                <section class="text-gray-400 bg-gray-900 body-font relative">
                    <div class="row g-3">
                    <div class="mb-4">
                        <label for="text" class="form-label text-gray-200">Text</label>
                        <textarea id="text" name="text" class="form-control form-control-lg" rows="4" placeholder="Enter text here..."></textarea>
                    </div>
                        <div class="col-md-6">
                            <label for="lang_one" class="form-label text-gray-200">From Language</label>
                            <select id="lang_one" name="lang_one" class="form-select form-select-lg">
                                <option value="AUTO_DETECT">Auto Detect</option>
                                <option value="EN">English</option>

                                <option value="BN">Bengali</option>
                                <option value="GU">Gujarati</option>
                                <option value="HI">Hindi</option>
                                <option value="MS">Malay</option>
                                <option value="ML">Malayalam</option>
                                <option value="MT">Maltese</option>
                                <option value="MR">Marathi</option>
                                <option value="NE">Nepali</option>
                                <option value="PA">Punjabi</option>
                                <option value="TA">Tamil</option>
                                <option value="TE">Telugu</option>
                                <option value="UR">Urdu</option>
                            </select>
                        </div>

                        <div class="col-md-6">
                            <label for="lang_two" class="form-label text-gray-200">To Language</label>
                            <select id="lang_two" name="lang_two" class="form-select form-select-lg">
                            <option value="EN">English</option>

                                <option value="BN">Bengali</option>
                                <option value="GU">Gujarati</option>
                                <option value="HI">Hindi</option>
                                <option value="MS">Malay</option>
                                <option value="ML">Malayalam</option>
                                <option value="MT">Maltese</option>
                                <option value="MR">Marathi</option>
                                <option value="NE">Nepali</option>
                                <option value="PA">Punjabi</option>
                                <option value="TA">Tamil</option>
                                <option value="TE">Telugu</option>
                                <option value="UR">Urdu</option>
                            </select>
                        </div>
                    </div>
                   <br>
                    <button id="convert" class="btn btn-lg btn-info w-100">Convert</button>
                </section>
            </div>
        </div>
    </div>
</div>

        </div>
    </div>
</div>

<!-- JavaScript -->
<script src="assets/js/jquery.min.js"></script>
<script src="assets/js/app.js"></script>
    </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
