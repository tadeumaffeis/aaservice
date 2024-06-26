#include <iostream>
#include "Functions.h"

void BubbleSort(long vet[], long size)
{
	for (int s=0; s < size;s++){
		for (int i = 0; i < size - 1; i++)
		{
			if (vet[i] > vet[i + 1])
			{
#ifdef _DEBUG_
                show_color(vet, size, i, i + 1);
#endif // _DEBUG_

				swap(vet, i, i + 1);
			}
		}
	}
}

