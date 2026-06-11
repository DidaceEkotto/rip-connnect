<?php

use App\Models\Product;
use Livewire\Component;
use Illuminate\Support\Facades\Storage;

new class extends Component
{
    public $page,$produits,$title;
    public function mount($page,$produits,$title)
    {
        $this->page = $page;
        $this->produits = $produits;
        $this->title = $title;
    }

     // Dans votre composant ProductList ou équivalent

    public function deleteProduct($productId)
    {
        try {
            $product = Product::findOrFail($productId);

            // Supprimer les images associées
            foreach ($product->images as $image) {
                Storage::disk('public')->delete($image->path);
                $image->delete();
            }

            // Supprimer le produit
            $product->delete();

            return redirect($this->page)->with('success', 'Produit supprimé avec succès!');
        } catch (\Exception $e) {
            session()->flash('error', 'Erreur lors de la suppression du produit.');
        }
    }

};
?>

<div>
    <div class="container-fluid p-4">

        <div class="mb-4 d-flex justify-content-between align-items-center">
            {{-- <h3 class="mb-0">Liste des produits</h3> --}}
            <a href="{{ route('admin.produits.ajouter') }}" wire:navigate class="btn btn-primary">
                <i class="bi bi-plus me-1"></i> Ajouter un produit
            </a>
        </div>

        <div class="card">
            <div class="card-body">
                @if (session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                @if ($produits->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover">
                            <thead class="table-light">
                                <tr>
                                    <th scope="col" width="50">#</th>
                                    <th scope="col">SKU</th>
                                    <th scope="col" width="100">Image</th>

                                    <th scope="col">Nom</th>
                                    <th scope="col">Type</th>
                                    <th scope="col">Prix</th>
                                    <th scope="col">Status</th>
                                    <th scope="col" width="150">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($this->produits as $index => $product)
                                    <tr>
                                        <th scope="row">{{ $index + 1 }}</th>
                                        <td>{{ $product->sku }}</td>
                                        <td>
                                            @if ($product->images->count() > 0)
                                                <img src="{{ asset($product->images->first()->path) }}"
                                                    alt="{{ $product->name }}" class="img-thumbnail"
                                                    style="width: 60px; height: 60px; object-fit: cover;">
                                            @else
                                                <div class="bg-light text-center p-2"
                                                    style="width: 60px; height: 60px;">
                                                    <i class="bi bi-image text-muted" style="font-size: 24px;"></i>
                                                </div>
                                            @endif
                                        </td>

                                        <td>{{ $product->name }}</td>
                                        <td>
                                            <span class="badge bg-info">
                                                {{ ucfirst($product->type_product) }}
                                            </span>
                                        </td>
                                        <td>{{ $product->prix }}</td>
                                        <td>
                                            @if ($product->status == 1)
                                                <span class="badge bg-success">Visible</span>
                                            @else
                                                <span class="badge bg-secondary">Non visible</span>
                                            @endif
                                        </td>
                                        <td>
                                            <div class="d-flex gap-1">
                                                <a href="{{ route('admin.produits.modifier', $product->id) }}"
                                                    wire:navigate class="btn btn-sm btn-outline-primary"
                                                    title="Modifier">
                                                    <i class="bi bi-pencil"></i>
                                                </a>
                                                <button type="button" class="btn btn-sm btn-outline-danger"
                                                    title="Supprimer" onclick="confirmDelete({{ $product->id }})">
                                                    <i class="bi bi-trash"></i>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    {{-- Pagination --}}
                    {{-- @if (method_exists($products, 'links'))
                        <div class="d-flex justify-content-center mt-4">
                            {{ $products->links() }}
                        </div>
                    @endif --}}
                @else
                    <div class="text-center py-5">
                        <i class="bi bi-inbox display-1 text-muted"></i>
                        <h5 class="text-muted mt-3">Aucun produit trouvé</h5>
                        <p class="text-muted">Commencez par ajouter votre premier produit</p>
                        <a href="{{ route('admin.produits.ajouter') }}" wire:navigate class="btn btn-primary mt-3">
                            <i class="bi bi-plus me-1"></i> Ajouter un produit
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>

    {{-- Script de confirmation de suppression --}}
    @push('scripts')
        <script>
            function confirmDelete(productId) {
                if (confirm('Êtes-vous sûr de vouloir supprimer ce produit ? Cette action est irréversible.')) {
                    @this.deleteProduct(productId);
                }
            }
        </script>
    @endpush

</div>

