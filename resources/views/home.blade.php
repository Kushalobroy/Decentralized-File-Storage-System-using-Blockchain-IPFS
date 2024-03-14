@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card bg-white border border-3  border-warning">
                
                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                    @if(session('message'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('message') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif
                        <!-- Modal for file preview -->
                        <div class="modal fade" id="filePreviewModal" tabindex="-1" aria-labelledby="filePreviewModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="filePreviewModalLabel">File Preview</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <!-- Image or PDF preview container -->
                                        <div id="file-preview-container"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                            <form action="{{route('add')}}" method="post" enctype="multipart/form-data">
                                @csrf
                                @if(Auth::check())
                                    <input type="hidden" name="userId" value="{{ Auth::user()->id }}">
                                @endif
                                    
                                <!-- Image preview container -->
                                
                                <div class="mb-2">
                                    <label for="file" class="form-label">Choose a file:</label>
                                    <input type="file" class="form-control" name="file" id="file" required onchange="previewFile()">
                                    
                                </div>
                                <div class="mb-2">
                                    <button type="submit" class="btn btn-primary btn-sm">Upload to IPFS</button>
                                    <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#filePreviewModal">
                                        Open Preview
                                    </button>
                                </div>
                                
                            </form>
                        </div> 
                        </div>
                    <div class="row">
                        
    @if(count($ipfsFiles) > 0)
    @foreach($ipfsFiles as $ipfsFile)
    <div class="col-md-3 mb-3">
        <div class="card border border-2  border-warning file">
            
                <div class="">
                    <iframe src="http://127.0.0.1:8080/ipfs/{{ $ipfsFile->ipfsHash }}" width="100%" ></iframe>
                </div>
                <div class="text-center m-1">
                    <button type="button" class="btn btn-outline-primary btn-sm" data-bs-toggle="modal" data-bs-target="#largeModal" data-file-hash="{{ $ipfsFile->ipfsHash }}">
                        view file
                        </button>
                </div>
        </div>
    </div>
    @endforeach
    @else
        <p>No files found for the user.</p>
    @endif
    
                    </div>  
                    
                    <!-- Bootstrap 5 Large Modal Template -->
                <div class="modal fade" id="largeModal" tabindex="-1" aria-labelledby="largeModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <iframe id="modalIframe" width="100%" height="500px"></iframe>
                        </div>
                       
                    </div>
                    </div>
                </div>
  
                                    
                                    
                                    
                                                    
                    </div>
                </div>
                
                    <div>
                        

                        
                    <div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
$('#largeModal').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget);
        var fileHash = button.data('file-hash');
        console.log(fileHash);
        var iframe = $('#modalIframe');
        iframe.attr('src', 'http://127.0.0.1:8080/ipfs/' + fileHash);
    });
</script>
<script>
    

    function previewFile() {
        // Get the file input
        var fileInput = document.getElementById('file');
        
        // Get the file
        var file = fileInput.files[0];

        // Create a FileReader object
        var reader = new FileReader();

        // Set the callback function when the file is loaded
        reader.onload = function (e) {
            // Check if the file is an image
            if (file.type.startsWith('image/')) {
                // Create an image element
                var imgElement = document.createElement('img');
                imgElement.setAttribute('src', e.target.result);
                imgElement.setAttribute('class', 'img-fluid');
                
                // Clear the previous preview
                document.getElementById('file-preview-container').innerHTML = '';

                // Append the image element to the preview container
                document.getElementById('file-preview-container').appendChild(imgElement);
            } else if (file.type === 'application/pdf') {
                // Create a PDF embed element
                var embedElement = document.createElement('embed');
                embedElement.setAttribute('src', e.target.result);
                embedElement.setAttribute('type', 'application/pdf');
                embedElement.setAttribute('width', '100%');
                embedElement.setAttribute('height', '500px');
                
                // Clear the previous preview
                document.getElementById('file-preview-container').innerHTML = '';

                // Append the embed element to the preview container
                document.getElementById('file-preview-container').appendChild(embedElement);
            } else {
                // Clear the previous preview if the file is not an image or PDF
                document.getElementById('file-preview-container').innerHTML = '';
            }
        };

        // Read the file as a data URL
        reader.readAsDataURL(file);
    }
</script>
@endsection
